<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\LoginRequest;
use Hash;
use Illuminate\Http\JsonResponse;
use MetricsWave\Users\Repositories\UserRepository;

class LoginController extends JsonTokenResponseController
{
    public function __construct(private readonly UserRepository $userRepository)
    {
        $this->middleware('guest');
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $user = $this->userRepository->firstByEmail($request->email);

        if (! Hash::check($request->password, $user->password)) {
            return $this->errorResponse('The provided credentials are incorrect.', 401);
        }

        return $this->tokenResponse($user, $request->device_name);
    }
}
