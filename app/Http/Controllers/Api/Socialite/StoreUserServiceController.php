<?php

namespace App\Http\Controllers\Api\Socialite;

use App\Http\Controllers\Api\Auth\JsonTokenResponseController;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Socialite;

class StoreUserServiceController extends JsonTokenResponseController
{
    public function __invoke(Service $service): JsonResponse
    {
        /** @var \Laravel\Socialite\Two\User $socialiteUser */
        $socialiteUser = Socialite::driver($service->driver)->stateless()->user();
        $deviceName = request()->query('deviceName');

        if ($deviceName === null) {
            $this->errorResponse('DeviceName is required', 400);
        }

        $user = User::query()
            ->updateOrCreate(
                ['email' => $socialiteUser->email],
                ['name' => $socialiteUser->name]
            );

        $user->services()->updateOrCreate(
            [
                'service_id' => $service->id,
                'user_id' => $user->id
            ],
            [
                'service_data' => [
                    'id' => $socialiteUser->id,
                    'token' => $socialiteUser->token,
                    'refreshToken' => $socialiteUser->refreshToken,
                    'expiresIn' => $socialiteUser->expiresIn,
                    'user' => $socialiteUser->user,
                    'attributes' => $socialiteUser->attributes,
                    'scope' => $service->scopes,
                ],
            ]
        );

        return $this->tokenResponse($user, $deviceName, $user->wasRecentlyCreated ? 201 : 200);
    }
}
