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
            ->subject('🚨 Trigger limit reached')
            ->greeting('🚨 Trigger limit reached')
            ->line('You have reached your trigger limit. Please upgrade your plan to continue receiving notifications.')
            ->line('You can upgrade your plan by clicking the button below.')
            ->action('Upgrade your plan', config('app.app_url').'settings/billing');
    }

    public function toArray(User $notifiable): array
    {
        return [
            'title' => 'Trigger limit reached',
            'content' => 'You have reached your trigger limit. Please upgrade your plan to continue receiving notifications.',
            'emoji' => '🚨',
            'trigger_id' => null,
            'trigger_type_id' => null,
        ];
    }
}
