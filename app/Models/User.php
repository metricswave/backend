<?php

namespace App\Models;

use App\Events\TriggerNotificationSent;
use App\Notifications\TriggerNotification;
use App\Services\Visits\Visits;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public const TRIGGER_NOTIFICATION = 'trigger-notification';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param  string  $deviceName
     * @return array{token: array{token: string, expires_at: int}, refresh_token: array{token: string, expires_at: int}}
     */
    public function createTokens(string $deviceName): array
    {
        return [
            'token' => $this->createAuthToken($deviceName),
            'refresh_token' => $this->createRefreshToken($deviceName),
        ];
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

    public function triggers(): HasMany
    {
        return $this->hasMany(Trigger::class);
    }

    public function notify($instance)
    {
        if ($instance instanceof TriggerNotification) {
            $this->triggerNotificationVisits()->increment();
            TriggerNotificationSent::dispatch($instance);
        }

        app(Dispatcher::class)->send($this, $instance);
    }

    public function triggerNotificationVisits(): Visits
    {
        return visitsService($this, self::TRIGGER_NOTIFICATION);
    }

    public function mailLogs(): HasMany
    {
        return $this->hasMany(MailLog::class, 'mail', 'email');
    }

    public function triggerNotificationVisitsLimitReached(): bool
    {
        return $this->triggerNotificationVisits()->period('month')->count() > $this->triggerMonthlyLimit();
    }

    public function triggerMonthlyLimit(): int
    {
        if ($this->email === 'victoor89@gmail.com') {
            return 10;
        }

        return 99999;
    }

    public function serviceToken(string $driver): string
    {
        $service = Service::query()->where('driver', $driver)->firstOrFail();

        return $this->services()->where('service_id', $service->id)->first()->service_data['token'];
    }

    public function services(): HasMany
    {
        return $this->hasMany(UserService::class);
    }
}
