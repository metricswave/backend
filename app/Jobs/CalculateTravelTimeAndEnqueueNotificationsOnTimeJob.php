<?php

namespace App\Jobs;

use App\Repositories\TriggerRepository;
use App\Services\Triggers\TimeToLeaveTriggersProcessor;
use App\Transfers\Time;
use App\Transfers\Weekday;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * @method static void dispatch(Time $time, Weekday $weekday)
 */
class CalculateTravelTimeAndEnqueueNotificationsOnTimeJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly Time $time,
        private readonly Weekday $weekday
    ) {
    }

    public function handle(TriggerRepository $repository, TimeToLeaveTriggersProcessor $processor): void
    {
        $triggers = $repository->timeToLeaveFor($this->time, $this->weekday);

        foreach ($triggers as $trigger) {
            ($processor)($trigger);
        }
    }
}
