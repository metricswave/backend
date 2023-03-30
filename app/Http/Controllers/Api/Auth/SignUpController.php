<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\SignUpRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class SignUpController extends JsonTokenResponse
{
    public function __construct(private readonly UserRepository $userRepository)
    {
        $this->middleware('guest');
    }

    public function __invoke(SignUpRequest $request): JsonResponse
    {
        $user = $this->userRepository->create($request->name, $request->email, $request->password);

        return $this->tokenResponse($user, $request->device_name, 201);
    }
}
