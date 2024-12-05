<?php

namespace MetricsWave\Teams;

use App\Models\Dashboard;
use App\Models\Price;
use App\Models\Trigger;
use App\Models\User;
use App\Services\Plans\PlanGetter;
use App\Transfers\PlanId;
use App\Transfers\PriceType;
use App\Transfers\SubscriptionType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;
use MetricsWave\Channels\TeamChannel;
use MetricsWave\Metrics\MetricsInterface;
use Str;

/**
 * @mixin IdeHelperTeam
 */
class Team extends Model
{
    use Billable;
    use HasFactory;
    use SoftDeletes;

    public const TRIGGER_NOTIFICATION = 'trigger-notification';

    protected $fillable = [
        'domain',
        'currency',
        'price_id',
        'initiated',
    ];

    protected $dispatchesEvents = [
        'deleted' => TeamDeleted::class,
        'created' => TeamCreated::class,
    ];

    protected $casts = [
        'initiated' => 'boolean',
    ];

    protected $appends = [
        'subscription_status',
        'subscription_type',
        'subscription_plan_id',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function dashboards(): HasMany
    {
        return $this->hasMany(Dashboard::class);
    }

    public function triggers(): HasMany
    {
        return $this->hasMany(Trigger::class);
    }

    public function channels(): HasMany
    {
        return $this->hasMany(TeamChannel::class);
    }

    public function invites(): HasMany
    {
        return $this->hasMany(TeamInvite::class);
    }

    public function monthlyLimits(): HasMany
    {
        return $this->hasMany(MonthlyLimit::class);
    }

    protected function domain(): Attribute
    {
        return Attribute::make(
            set: function (string $value): string {
                return Str::of($value)->replace(['http://', 'https://'], '')
                    ->replace('www.', '')
                    ->trim('/')
                    ->lower()
                    ->toString();
            },
        );
    }

    public function triggerNotificationVisitsLimitReached(): bool
    {
        return $this->triggerNotificationVisits()->period('month')->count() > $this->triggerMonthlyLimit();
    }

    public function triggerNotificationVisits(): MetricsInterface
    {
        return visitsService($this, self::TRIGGER_NOTIFICATION);
    }

    public function triggerMonthlyLimit(): ?int
    {
        /** @var PlanGetter $planGetter */
        $planGetter = app(PlanGetter::class);

        return $planGetter->get($this->subscription_plan_id)->eventsLimit;
    }

    public function getSubscriptionStatusAttribute(): bool
    {
        if ($this->price_id !== null) {
            return true;
        }

        if ($this->subscriptions->whereIn('stripe_status', ['active', 'trailing'])->count() > 0) {
            return true;
        }

        return false;
    }

    public function getFullSubscriptionPlanIdAttribute(): string
    {
        if ($this->subscription_plan_id === PlanId::FREE) {
            return $this->subscription_plan_id->name();
        }

        $paying = $this->price_id !== null ? ' (Free)' : '';

        return $this->subscription_plan_id->name().$paying;
    }

    public function getSubscriptionPlanIdAttribute(): PlanId
    {
        if ($this->price_id !== null) {
            return PlanId::from($this->price_id);
        }

        if ($this->subscription_status === false) {
            return PlanId::FREE;
        }

        if ($this->subscribed(config('services.stripe.basic.id'))) {
            return PlanId::BASIC;
        }

        if ($this->subscribed(config('services.stripe.starter.id'))) {
            return PlanId::STARTER;
        }

        if ($this->subscribed(config('services.stripe.corporate.id'))) {
            return PlanId::CORPORATE;
        }

        return PlanId::BUSINESS;
    }

    public function getSubscriptionTypeAttribute(): SubscriptionType
    {
        if ($this->subscription_status === false) {
            return SubscriptionType::Free;
        }

        if ($this->price_id) {
            $price = Price::query()->find($this->price_id);

            if ($price->type === PriceType::Lifetime) {
                return SubscriptionType::Lifetime;
            }
        }

        return SubscriptionType::Monthly;
    }

    public function stripeName(): string
    {
        return $this->owner?->name;
    }

    public function stripeEmail(): string
    {
        return $this->owner?->email ?? '';
    }

    public function stripeMetadata(): array
    {
        return [
            'team_id' => $this->id,
            'domain' => $this->domain,
        ];
    }

    public function preferredCurrency(): string
    {
        return $this->currency ?? 'usd';
    }

    public function softLimit(): bool
    {
        $previousMonth = now()->subMonthNoOverflow();

        return $this->monthlyLimits()
            ->where(fn ($query) => $query
                ->where(fn ($query) => $query
                    ->where('year', now()->year)
                    ->where('month', now()->month)
                )
                ->orWhere(fn ($query) => $query
                    ->where('year', $previousMonth->year)
                    ->where('month', $previousMonth->month)
                )
            )
            ->exists();
    }

    public function hardLimit(): bool
    {
        $previousMonth = now()->subMonthNoOverflow();

        if (in_array($this->owner->email, User::EMAILS_WITH_PRIVILEGES)) {
            return false;
        }

        return $this->monthlyLimits()
            ->where(fn ($query) => $query
                ->where(fn ($query) => $query
                    ->where('year', now()->year)
                    ->where('month', now()->month)
                )
                ->orWhere(fn ($query) => $query
                    ->where('year', $previousMonth->year)
                    ->where('month', $previousMonth->month)
                )
            )
            ->count() == 2;
    }
}
