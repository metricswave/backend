<?php

namespace App\Jobs;

use App\Notifications\TriggerNotification;
use App\Repositories\TriggerRepository;
use App\Services\TravelDistance\Address;
use App\Services\TravelDistance\ArrivalTime;
use App\Services\TravelDistance\TravelDistanceCalculator;
use App\Services\TravelDistance\TravelMode;
use App\Transfers\Time;
use App\Transfers\Weekday;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

/**
 * @method static void dispatch(Time $time, Weekday $weekday)
 */
class CalculateTravelTimeAndEnqueueNotificationsOnTimeJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private const MINUTES_BEFORE = 10;

    public function __construct(
        private readonly Time $time,
        private readonly Weekday $weekday
    ) {
    }

    public function handle(TriggerRepository $repository, TravelDistanceCalculator $calculator): void
    {
        $triggers = $repository->timeToLeaveFor($this->time, $this->weekday);

        foreach ($triggers as $trigger) {
            $arrivalTime = ArrivalTime::fromTimeFormatted($trigger->configuration['fields']['arrival_time']);

            $travelDistance = $calculator->calculate(
                new Address($trigger->configuration['fields']['origin']),
                new Address($trigger->configuration['fields']['destination']),
                TravelMode::from($trigger->configuration['fields']['mode']),
                $arrivalTime
            );

            $notification = new TriggerNotification($trigger, Arr::dot($travelDistance->toArray()));

            UserTriggerNotificationJob::dispatch($trigger->user, $notification)
                ->delay(
                    $arrivalTime->date
                        ->subSeconds($travelDistance->duration->seconds)
                        ->subMinutes(self::MINUTES_BEFORE)
                );
        }
    }
}
