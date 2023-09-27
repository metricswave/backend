<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\JsonController;
use App\Http\Requests\ForgotPasswordRequest;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use MetricsWave\Users\User;

class ForgotPasswordController extends JsonController
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function __invoke(ForgotPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink(['email' => $request->email], function (User $user, string $token) {
            $user->notify(new ResetPasswordNotification($token));
        });

        if ($status === Password::RESET_LINK_SENT) {
            return $this->response(['message' => 'Reset link sent to your email.']);
        }

        return $this->errorResponse('Unable to send reset link.', 404);
    }
}
