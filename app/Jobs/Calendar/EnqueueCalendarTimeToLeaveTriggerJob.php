<?php

namespace App\Jobs\Calendar;

use App\Repositories\TriggerRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * @method static PendingDispatch dispatch()
 * @method static PendingDispatch dispatchSync()
 */
class EnqueueCalendarTimeToLeaveTriggerJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle(TriggerRepository $repository): void
    {
        $triggers = $repository->calendarTimeToLeave();

        foreach ($triggers as $trigger) {
            EnqueueCalendarTimeToLeaveEventNotificationsJob::dispatch($trigger);
        }
    }
}
