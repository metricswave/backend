<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use MetricsWave\Teams\Team;

class TriggerLimitReachedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Team $team)
    {
    }

    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage())
            ->from('victor@metricswave.com')
            ->subject('Try metricswave free for a month')
            ->view('mail.trigger_limit_reached_notification', [
                'coupon' => 'FIRSTMONTHFREE',
                'name' => $this->team->owner->name,
                'domain' => $this->team->domain,
                'url' => config('app.web_app_url').'settings/billing?utm_source=trigger_limit_reached_notification',
            ]);
    }

    public function toArray(User $notifiable): array
    {
        return [
            'title' => 'Events limit reached',
            'content' => 'You have reached the event limit for your current plan. We will continue to process and record all events and visits that come to us from your site, but your access to the dashboard may be restricted soon.',
            'emoji' => '🚨',
            'trigger_id' => null,
            'trigger_type_id' => null,
        ];
    }
}
