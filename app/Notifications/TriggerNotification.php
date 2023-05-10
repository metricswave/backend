<?php

namespace App\Notifications;

use App\Models\Trigger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use NotificationChannels\Telegram\TelegramMessage;
use Str;
use function Emoji\is_single_emoji;

class TriggerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Trigger $trigger, private readonly array $params = [])
    {
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
            'emoji' => $this->emoji(),
            'trigger_id' => $this->trigger->id,
            'trigger_type_id' => $this->trigger->trigger_type_id,
        ];
    }

    private function emoji(): string
    {
        if (is_single_emoji($this->params['emoji'] ?? null)) {
            return $this->params['emoji'];
        }

        return $this->trigger->emoji;
    }

    public function toTelegram($notifiable)
    {
        $emoji = $this->emoji();
        $title = $this->trigger->formattedTitle($this->params);
        $content = $this->trigger->formattedContent($this->params);

        $telegramChatIds = collect($this->trigger->via)
            ->filter(fn($via) => $via['checked'] && $via['type'] === 'telegram')
            ->map(fn($via) => $via['value'])
            ->toArray();

        $messages = [];

        foreach ($telegramChatIds as $chatId) {
            $messages[] = TelegramMessage::create()
                ->options(['parse_mode' => 'HTML'])
                ->token(config('services.telegram-bot-api.token'))
                ->to($chatId)
                ->content(
                    Str::of("**${emoji} ${title}**\n\n${content}")
                        ->inlineMarkdown()
                        ->toString()
                );
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
                'emoji' => $this->emoji(),
                'title' => $this->trigger->formattedTitle($this->params),
                'content' => $this->trigger->formattedContent($this->params),
            ]);
    }

    public function middleware(): array
    {
        return [
            (new WithoutOverlapping($this->trigger->user->id))->releaseAfter(Date::now()->addSeconds(5)),
        ];
    }

    public function retryUntil(): Carbon
    {
        return now()->addMinutes(15);
    }
}
