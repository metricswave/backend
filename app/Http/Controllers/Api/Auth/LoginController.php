<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;
use Hash;
use Illuminate\Http\JsonResponse;

class LoginController extends JsonTokenResponse
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

        return $this->tokenResponse($user, $request->device_name);
    }
}
