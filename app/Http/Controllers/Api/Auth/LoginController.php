<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\JsonController;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Hash;
use Illuminate\Http\JsonResponse;

class LoginController extends JsonController
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $user = $this->userRepository->firstByEmail($request->email);

        if (!Hash::check($request->password, $user->password)) {
            return $this->errorResponse('The provided credentials are incorrect.', 401);
        }

        return $this->response([
            'token' => $this->token($user, $request->device_name),
            'refresh_token' => $this->refreshToken($user, $request->device_name),
        ]);
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
