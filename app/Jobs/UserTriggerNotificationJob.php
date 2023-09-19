<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\TriggerNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use MetricsWave\Teams\Team;

/**
 * @method static PendingDispatch dispatch(Team $team, TriggerNotification $notification)
 * @method static PendingDispatch dispatchSync(Team $team, TriggerNotification $notification)
 */
class UserTriggerNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private User $user;

    public function __construct(
        private readonly Team $team,
        private readonly TriggerNotification $notification
    ) {
        $this->user = $this->team->owner;
    }

    public function handle(): void
    {
        $this->enqueueTelegramNotificationsInAnotherJob();

        $this->user->notify($this->notification);
    }

    private function enqueueTelegramNotificationsInAnotherJob(): void
    {
        $serviceIds = collect($this->notification->trigger->via)
            ->filter(fn ($via) => $via['checked'] && $via['type'] === 'telegram')
            ->map(fn ($via) => $via['id']);

        $telegramChannels = $this->team->channels()->whereIn('id', $serviceIds)->get();

        foreach ($telegramChannels as $telegramChannel) {
            UserTriggerTelegramNotificationJob::dispatch(
                $this->notification,
                $telegramChannel,
            );
        }
    }
}
