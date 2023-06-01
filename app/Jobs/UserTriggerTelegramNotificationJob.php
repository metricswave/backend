<?php

namespace App\Jobs;

use App\Notifications\TelegramErrorNotification;
use App\Notifications\TriggerNotification;
use App\Transfers\TelegramChannelErrors;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NotificationChannels\Telegram\TelegramMessage;
use Str;

/**
 * @method static PendingDispatch dispatch(TriggerNotification $notification, string $telegramChatId)
 * @method static PendingDispatch dispatchSync(TriggerNotification $notification, string $telegramChatId)
 */
class UserTriggerTelegramNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly TriggerNotification $notification,
        private readonly string $telegramChatId,
    ) {
    }

    public function handle(): void
    {
        // todo: uncomment this when we have a billing system
        // $user = $this->trigger->user;
        // if ($user->triggerNotificationVisitsLimitReached()) {
        //     return;
        // }

        $emoji = $this->notification->emoji;
        $title = $this->notification->title;
        $content = $this->notification->content;

        try {
            TelegramMessage::create()
                ->options(['parse_mode' => 'HTML'])
                ->token(config('services.telegram-bot-api.token'))
                ->to($this->telegramChatId)
                ->content(
                    Str::of("**${emoji} ${title}**\n\n${content}")
                        ->inlineMarkdown()
                        ->toString()
                )->send();
        } catch (ClientException $e) {
            if (
                $e->getCode() === 400
                && $e->getMessage() === 'Bad Request: group chat was upgraded to a supergroup chat'
            ) {
                $this->notification->trigger->user->notify(
                    new TelegramErrorNotification(
                        $this->telegramChatId,
                        TelegramChannelErrors::GROUP_CHAT_UPGRADED_TO_SUPERGROUP_CHAT,
                    )
                );
            }

            throw $e;
        }
    }
}
