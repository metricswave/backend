<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\SignUpRequest;
use App\Models\Lead;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class SignUpController extends JsonTokenResponseController
{
    public function __construct(private readonly UserRepository $userRepository)
    {
        $this->middleware('guest');
    }

    public function __invoke(SignUpRequest $request): JsonResponse
    {
        if (!Lead::query()->where('email', $request->email)->whereNotNull('paid_at')->exists()) {
            return $this->errorResponse('Only paid license users can create an account right now.', 409);
        }

        $user = $this->userRepository->create($request->name, $request->email, $request->password);

        return $this->tokenResponse($user, $request->device_name, 201);
    }
}
