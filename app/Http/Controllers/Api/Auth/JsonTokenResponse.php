<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\JsonController;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class JsonTokenResponse extends JsonController
{
    protected function tokenResponse(User $user, string $deviceName, int $code = 200): JsonResponse
    {
        return $this->response(
            [
                'token' => $this->token($user, $deviceName),
                'refresh_token' => $this->refreshToken($user, $deviceName),
            ],
            $code
        );
    }

    private function token(User $user, string $deviceName): array
    {
        $expiresAt = now()->addDay();

        return [
            'token' => $user
                ->createToken(
                    name: $deviceName,
                    expiresAt: $expiresAt
                )->plainTextToken,
            'expires_at' => $expiresAt->timestamp,
        ];
    }

    private function refreshToken(User $user, string $deviceName): array
    {
        $expiresAt = now()->addWeek();

        return [
            'token' => $user
                ->createToken(
                    name: $deviceName,
                    abilities: ['refresh'],
                    expiresAt: $expiresAt,
                )->plainTextToken,
            'expires_at' => $expiresAt->timestamp,
        ];
    }
}
