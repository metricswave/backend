<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends JsonTokenResponse
{
    public function __construct(private readonly UserRepository $userRepository)
    {
        $this->middleware('guest');
    }

    public function __invoke(ResetPasswordRequest $request): JsonResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            $user = $this->userRepository->firstByEmail($request->email);
            return $this->tokenResponse($user, $request->device_name);
        }

        return $this->errorResponse('Unable to reset password.', 404);
    }
}
