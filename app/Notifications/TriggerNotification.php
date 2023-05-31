<?php

namespace App\Notifications;

use App\Models\Trigger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TriggerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public readonly string $title;
    public readonly string $content;
    public readonly string $emoji;

    public function __construct(public readonly Trigger $trigger, public readonly array $params = [])
    {
        $this->title = $trigger->formattedTitle($params);
        $this->content = $trigger->formattedContent($params);
        $this->emoji = $trigger->formattedEmoji($params);
    }

    public function via(object $notifiable): array
    {
        // todo: uncomment this when we have a billing system
        // $user = $this->trigger->user;
        // if ($user->triggerNotificationVisitsLimitReached()) {
        //     return ['database'];
        // }

        $this->trigger->visits()->increment();

        $via = collect($this->trigger->via)
            ->filter(fn($via) => $via['checked'] && $via['type'] !== 'telegram')
            ->unique('type')
            ->map(fn($via) => $via['type'])
            ->toArray();

        return [
            'database',
            ...$via,
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'emoji' => $this->emoji,
            'trigger_id' => $this->trigger->id,
            'trigger_type_id' => $this->trigger->trigger_type_id,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject($this->trigger->emoji.' '.$this->title)
            ->markdown('mail.trigger', [
                'emoji' => $this->emoji,
                'title' => $this->title,
                'content' => $this->content,
            ]);
    }
}
