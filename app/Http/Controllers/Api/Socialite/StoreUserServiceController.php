<?php

namespace App\Http\Controllers\Api\Socialite;

use App\Http\Controllers\Api\Auth\JsonTokenResponseController;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Two\User as SocialiteUser;
use Socialite;

class StoreUserServiceController extends JsonTokenResponseController
{
    public function __construct()
    {
    }

    public function __invoke(Service $service): JsonResponse
    {
        /** @var SocialiteUser $socialiteUser */
        $socialiteUser = Socialite::driver($service->driver)->stateless()->user();
        $deviceName = request()->query('deviceName');

        if ($deviceName === null) {
            $this->errorResponse('DeviceName is required', 400);
        }

        $existingUser = User::query()->where('email', $socialiteUser->email)->first();

        if ($existingUser === null) {
            return $this->errorResponse(
                'MetricsWave is shutting down. New registrations are no longer accepted. The service will be discontinued in June 2025.',
                410,
            );
        }

        $user = $existingUser;

        $user->services()->updateOrCreate(
            [
                'service_id' => $service->id,
                'user_id' => $user->id,
            ],
            [
                'reconectable' => false,
                'service_data' => [
                    'id' => $socialiteUser->id,
                    'token' => $socialiteUser->token,
                    'refreshToken' => $socialiteUser->refreshToken,
                    'expiresIn' => $socialiteUser->expiresIn,
                    'user' => $socialiteUser->user,
                    'attributes' => $socialiteUser->attributes,
                    'scope' => $socialiteUser->approvedScopes,
                ],
            ]
        );

        return $this->tokenResponse($user, $deviceName, 200);
    }
}
