<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;

class ResetPasswordNotification extends ResetPassword
{
    protected function resetUrl($notifiable): string
    {
        return config('app.url').
            '/auth/reset-password?token='.$this->token.
            '&email='.$notifiable->getEmailForPasswordReset();
    }
}
