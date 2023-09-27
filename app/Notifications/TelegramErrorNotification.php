<?php

namespace App\Notifications;

use App\Services\CacheKey;
use App\Transfers\TelegramChannelErrors;
use Cache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use MetricsWave\Users\User;
use MetricsWave\Users\UserService;

class TelegramErrorNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private readonly UserService $userService;

    public function __construct(
        private readonly string $channelId,
        private readonly TelegramChannelErrors $error,
    ) {
        $this->userService = UserService::where('channel_id', $this->channelId)->first();
    }

    public function via(User $notifiable): array
    {
        if (TelegramChannelErrors::GROUP_CHAT_UPGRADED_TO_SUPERGROUP_CHAT !== $this->error) {
            return [];
        }

        $key = CacheKey::generate('telegram_error_notification', $this->channelId);
        if (Cache::has($key)) {
            return [];
        }

        Cache::put($key, true, now()->addDays(2));

        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        $channelName = $this->userService->service_data['configuration']['channel_name'] ?? null;
        if ($channelName) {
            $subject = "🚨 We can't send your Telegram channel '{$channelName}'";
        } else {
            $subject = "🚨 We can't send your Telegram channel";
        }

        return (new MailMessage())
            ->subject($subject)
            ->greeting($subject)
            ->line('We can\'t send notifications to your Telegram channel because it has been updated.')
            ->line('To fix this, please check that NotifyWaveBot is still an admin of your channel and that the group ID still matches the one in your channel settings.')
            ->line('After checking this, if you need help, please reply to this email.');
    }

    public function toArray(User $notifiable): array
    {
        return [
            'title' => 'Error sending Telegram notification',
            'channel_id' => $this->channelId,
            'error' => $this->error->value,
        ];
    }
}
