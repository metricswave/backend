<?php

namespace App\Notifications;

use App\Models\Trigger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class TriggerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Trigger $trigger, private readonly array $params = [])
    {
    }

    public function via(object $notifiable): array
    {
        $via = collect($this->trigger->via)
            ->filter(fn($via) => $via['checked'])
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
            'title' => $this->trigger->formattedTitle($this->params),
            'content' => $this->trigger->formattedContent($this->params),
            'emoji' => $this->trigger->emoji,
            'trigger_id' => $this->trigger->id,
            'trigger_type_id' => $this->trigger->trigger_type_id,
        ];
    }

    public function toTelegram($notifiable)
    {
        $emoji = $this->trigger->emoji;
        $title = $this->trigger->formattedTitle($this->params);
        $content = $this->trigger->formattedContent($this->params);

        $telegramChatIds = collect($this->trigger->via)
            ->filter(fn($via) => $via['checked'] && $via['type'] === 'telegram')
            ->map(fn($via) => $via['value'])
            ->toArray();

        $messages = [];

        foreach ($telegramChatIds as $chatId) {
            $messages[] = TelegramMessage::create()
                ->token(config('services.telegram-bot-api.token'))
                ->to($chatId)
                ->content("*${emoji} ${title}*\n${content}");
        }

        foreach (array_slice($messages, 0, -1) as $message) {
            $message->send();
        }

        return end($messages);
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject($this->trigger->emoji.' '.$this->trigger->formattedTitle($this->params))
            ->markdown('mail.trigger', [
                'emoji' => $this->trigger->emoji,
                'title' => $this->trigger->formattedTitle($this->params),
                'content' => $this->trigger->formattedContent($this->params),
            ]);
    }
}
