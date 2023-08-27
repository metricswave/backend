<?php

namespace App\Jobs;

use App\Models\UserService;
use App\Notifications\TriggerNotification;
use App\Services\CacheKey;
use Cache;
use Carbon\Carbon;
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
            if ($this->requestExceptionBecauseGroupIdChanged($e)) {
                $response = $e->response->json();
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
        $token = config('services.telegram-bot-api.token');
        $exception = $this->send($token, $telegramChannelId, $emoji, $title, $content);

        if ($exception === null) {
            return;
        } elseif ($this->requestExceptionBecauseChatNotFound($exception)) {
            return;
        } elseif ($this->requestExceptionBecauseGroupIdChanged($exception)) {
            throw $exception;
        }

        if (now()->isBefore(Carbon::createFromDate(2023, 07, 01))) {
            $token = config('services.telegram-bot-api.old_token');
            $exception = $this->send($token, $telegramChannelId, $emoji, $title, $content);

            if ($exception === null) {
                $key = CacheKey::generate('telegram_channel', $telegramChannelId);
                if (! Cache::has($key)) {
                    $this->send(
                        $token,
                        $telegramChannelId,
                        '⚠️',
                        'This bot is deprecated!',
                        'This bot is deprecated and will be removed on 1st July 2023. Please replace me with @MetricsWaveBot in this channel.'
                    );
                    Cache::put($key, true, now()->addDay());
                }

                return;
            }
        }

        throw $exception;
    }

    private function send(
        mixed $token,
        string $telegramChannelId,
        string $emoji,
        string $title,
        string $content
    ): ?RequestException {
        return Http::post('https://api.telegram.org/bot'.$token.'/sendMessage', [
            'chat_id' => $telegramChannelId,
            'text' => Str::of("**${emoji} ${title}**\n\n${content}")
                ->inlineMarkdown()
                ->toString(),
            'parse_mode' => 'HTML',
        ])->toException();
    }

    public function requestExceptionBecauseGroupIdChanged(RequestException $exception): bool
    {
        $response = $exception->response->json();

        return
            $response['ok'] === false
            && $response['error_code'] === 400
            && $response['description'] === 'Bad Request: group chat was upgraded to a supergroup chat'
            && isset($response['parameters']['migrate_to_chat_id']);
    }

    private function requestExceptionBecauseChatNotFound(RequestException $exception): bool
    {
        $response = $exception->response->json();

        return
            $response['ok'] === false
            && $response['error_code'] === 400
            && $response['description'] === 'Bad Request: chat not found';
    }
}
