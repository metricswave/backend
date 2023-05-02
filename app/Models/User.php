<?php

namespace App\Models;

use App\Events\TriggerNotificationSent;
use App\Notifications\TriggerNotification;
use Awssat\Visits\Visits;
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
        $expiresAt = now()->addDay();

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
        $expiresAt = now()->addWeek();

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

    public function services(): HasMany
    {
        return $this->hasMany(UserService::class);
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
        return visits($this, 'trigger-notification');
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
}
