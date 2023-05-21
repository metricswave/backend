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

/**
 * @method static PendingDispatch dispatch(User $user, TriggerNotification $notification)
 * @method static PendingDispatch dispatchSync(User $user, TriggerNotification $notification)
 */
class UserTriggerNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly User $user,
        private readonly TriggerNotification $notification
    ) {
    }

    public function handle(): void
    {
        $this->user->notify($this->notification);
    }
}
