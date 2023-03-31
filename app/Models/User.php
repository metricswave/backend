<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
}
