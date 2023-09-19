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
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Cashier\Billable;
use MetricsWave\Channels\TeamChannel;
use MetricsWave\Metrics\MetricsInterface;

class Team extends Model
{
    use HasFactory;
    use Billable;

    public const TRIGGER_NOTIFICATION = 'trigger-notification';

    protected $fillable = [
        'domain',
        'price_id',
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

        if ($this->subscriptions()->whereIn('stripe_status', ['active', 'trailing'])->exists()) {
            return true;
        }

        return false;
    }

    public function getSubscriptionPlanIdAttribute(): PlanId
    {
        if ($this->subscription_status === false) {
            return PlanId::FREE;
        }

        if ($this->subscribedToProduct(PlanGetter::BASIC_PRODUCT_ID)) {
            return PlanId::BASIC;
        }

        if ($this->subscribedToProduct(PlanGetter::STARTER_PRODUCT_ID)) {
            return PlanId::STARTER;
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
}
