<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TriggerLimitReachedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('🚨 Events limit reached')
            ->greeting('🚨 Events limit reached')
            ->line('You have reached your event limit. Please upgrade your plan to continue monitoring your price.')
            ->line('You can upgrade your plan by clicking the button below.')
            ->action(
                'Upgrade your plan',
                config('app.web_app_url').'settings/billing?utm_source=trigger_limit_reached_notification'
            );
    }

    public function toArray(User $notifiable): array
    {
        return [
            'title' => 'Events limit reached',
            'content' => 'You have reached your event limit. Please upgrade your plan to continue receiving notifications.',
            'emoji' => '🚨',
            'trigger_id' => null,
            'trigger_type_id' => null,
        ];
    }
}
