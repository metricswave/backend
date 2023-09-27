<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\CanNotCreateUserBecauseNoPaidLicence;
use App\Http\Requests\SignUpRequest;
use Illuminate\Http\JsonResponse;
use MetricsWave\Users\Repositories\UserRepository;

class SignUpController extends JsonTokenResponseController
{
    public function __construct(private readonly UserRepository $userRepository)
    {
        $this->middleware('guest');
    }

    public function __invoke(SignUpRequest $request): JsonResponse
    {
        try {
            $user = $this->userRepository->create($request->name, $request->email, $request->password);
        } catch (CanNotCreateUserBecauseNoPaidLicence) {
            return $this->errorResponse('Only paid license users can create an account right now.', 409);
        }

        return $this->tokenResponse($user, $request->device_name, 201);
    }
}
