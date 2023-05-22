<?php

namespace App\Http\Controllers\Api\Socialite;

use App\Exceptions\CanNotCreateUserBecauseNoPaidLicence;
use App\Http\Controllers\Api\Auth\JsonTokenResponseController;
use App\Models\Service;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Two\User;
use Socialite;

class StoreUserServiceController extends JsonTokenResponseController
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function __invoke(Service $service): JsonResponse
    {
        /** @var User $socialiteUser */
        $socialiteUser = Socialite::driver($service->driver)->stateless()->user();
        $deviceName = request()->query('deviceName');

        if ($deviceName === null) {
            $this->errorResponse('DeviceName is required', 400);
        }

        try {
            $user = $this->userRepository->updateOrCreate($socialiteUser->email, [
                'name' => $socialiteUser->name,
            ]);
        } catch (CanNotCreateUserBecauseNoPaidLicence) {
            return $this->errorResponse('Only paid license users can create an account right now.', 409);
        }

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
                    'scope' => $socialiteUser->approvedScopes,
                ],
            ]
        );

        return $this->tokenResponse($user, $deviceName, $user->wasRecentlyCreated ? 201 : 200);
    }
}
