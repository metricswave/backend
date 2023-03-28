<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Hash;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $user = $this->userRepository->firstByEmail($request->email);

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        return response()->json([
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
