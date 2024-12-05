<?php

namespace App\Models;

use App\Events\CheckTriggerLimitUsage;
use App\Events\UserCreated;
use App\Notifications\TriggerNotification;
use App\Services\CacheKey;
use App\Transfers\ServiceId;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use MetricsWave\Metrics\MetricsInterface;
use MetricsWave\Teams\Team;
use MetricsWave\Users\UserService;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public const DOMAIN = 'domain';

    public const TRIGGER_NOTIFICATION = 'trigger-notification';

    public const EMAILS_WITH_PRIVILEGES = ['3comunicacionlpa@gmail.com'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'marketing_mailable',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'teams',
        'ownedTeams',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'marketing_mailable' => 'boolean',
    ];

    protected $dispatchesEvents = [
        'created' => UserCreated::class,
    ];

    protected $appends = [
        'all_teams',
    ];

    /**
     * @return array{token: array{token: string, expires_at: int}, refresh_token: array{token: string, expires_at: int}}
     */
    public function createTokens(string $deviceName): array
    {
        return [
            'token' => $this->createAuthToken($deviceName),
            'refresh_token' => $this->createRefreshToken($deviceName),
        ];
    }

    public function firstName(): Attribute
    {
        return Attribute::make(
            get: fn () => explode(' ', $this->name)[0] ?? $this->name,
        );
    }

    public function notify($instance): void
    {
        if ($instance instanceof TriggerNotification) {
            $team = $instance->trigger->team;
            $team->triggerNotificationVisits()->increment();
            $team->triggerNotificationVisits()->recordParams([
                'user_parameter' => $team->owner->email,
                'team' => $team->domain,
                'plan' => $team->full_subscription_plan_id,
            ], totalOnly: true);

            $key = CacheKey::generateForModel($team, 'trigger_check_limit_usage');
            if (! Cache::has($key)) {
                CheckTriggerLimitUsage::dispatch($instance);
                Cache::put($key, '1', now()->addDays(1));
            }
        }

        app(Dispatcher::class)->send($this, $instance);
    }

    public function triggerNotificationVisits(): MetricsInterface
    {
        return visitsService($this, self::TRIGGER_NOTIFICATION);
    }

    public function mailLogs(): HasMany
    {
        return $this->hasMany(MailLog::class, 'mail', 'email');
    }

    public function userServiceById(ServiceId $serviceId): ?UserService
    {
        /** @var UserService|null $service */
        $service = $this->services()->where('service_id', $serviceId->value)->first();

        return $service;
    }

    public function services(): HasMany
    {
        return $this->hasMany(UserService::class);
    }

    public function isOwnerOfTeam(int|Team $team): bool
    {
        if ($team instanceof Team) {
            $team = $team->id;
        }

        return $this->ownedTeams->where('id', $team)->isNotEmpty();
    }

    public function hasAccessToTeam(int|Team $team): bool
    {
        if ($team instanceof Team) {
            $team = $team->id;
        }

        return $this->all_teams->where('id', $team)->isNotEmpty();
    }

    public function getAllTeamsAttribute(): Collection
    {
        return Team::with(['subscriptions'])
            ->whereHas('users', fn ($query) => $query->where('user_id', $this->id))
            ->orWhere('owner_id', $this->id)
            ->get();
    }

    public function ownedTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'owner_id');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_user');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->email, config('app.filament.users_emails'));
    }

    private function createAuthToken(string $deviceName): array
    {
        $expiresAt = now()->addYear();

        return [
            'token' => $this
                ->createToken(
                    name: $deviceName,
                    abilities: [TokenAbility::API],
                    expiresAt: $expiresAt
                )->plainTextToken,
            'expires_at' => $expiresAt->timestamp,
        ];
    }

    private function createRefreshToken(string $deviceName): array
    {
        $expiresAt = now()->addYears(2);

        return [
            'token' => $this
                ->createToken(
                    name: $deviceName,
                    abilities: [TokenAbility::REFRESH],
                    expiresAt: $expiresAt,
                )->plainTextToken,
            'expires_at' => $expiresAt->timestamp,
        ];
    }

    public function notifications()
    {
        return $this->morphMany(DatabaseNotifications::class, 'notifiable')->latest();
    }
}
