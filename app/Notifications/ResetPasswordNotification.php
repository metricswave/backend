<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;

class ResetPasswordNotification extends ResetPassword
{
    protected function resetUrl($notifiable): string
    {
        return config('app.web_app_url').
            'auth/reset-password?token='.$this->token.
            '&email='.$notifiable->getEmailForPasswordReset();
    }
}
