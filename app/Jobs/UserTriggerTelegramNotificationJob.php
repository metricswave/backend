<?php

namespace App\Jobs;

use App\Models\UserService;
use App\Notifications\TriggerNotification;
use Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Str;

/**
 * @method static PendingDispatch dispatch(TriggerNotification $notification, UserService $userService)
 * @method static PendingDispatch dispatchSync(TriggerNotification $notification, UserService $userService)
 */
class UserTriggerTelegramNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly TriggerNotification $notification,
        private readonly UserService $userService
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

        $chatId = $this->userService->service_data['configuration']['channel_id'];

        try {
            $this->sendTelegramMessageTo($chatId, $emoji, $title, $content);
        } catch (RequestException $e) {
            $response = $e->response->json();

            if (
                $response['ok'] === false
                && $response['error_code'] === 400
                && $response['description'] === 'Bad Request: group chat was upgraded to a supergroup chat'
                && isset($response['parameters']['migrate_to_chat_id'])
            ) {
                $migrateToChatId = $response['parameters']['migrate_to_chat_id'];

                $data = $this->userService->service_data;
                $data['configuration']['channel_id'] = $migrateToChatId;
                $this->userService->service_data = $data;
                $this->userService->save();

                $this->sendTelegramMessageTo(
                    $migrateToChatId,
                    $emoji,
                    $title,
                    $content
                );

                return;
            }

            throw $e;
        }
    }

    private function sendTelegramMessageTo(
        string $telegramChannelId,
        string $emoji,
        string $title,
        string $content
    ): void {
        Http::post("https://api.telegram.org/bot".config('services.telegram-bot-api.token')."/sendMessage", [
            'chat_id' => $telegramChannelId,
            'text' => Str::of("**${emoji} ${title}**\n\n${content}")
                ->inlineMarkdown()
                ->toString(),
            'parse_mode' => 'HTML',
        ])->throw();
    }
}
