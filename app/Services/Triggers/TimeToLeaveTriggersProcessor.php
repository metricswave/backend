<?php

namespace App\Services\Triggers;

use App\Jobs\UserTriggerNotificationJob;
use App\Models\Trigger;
use App\Notifications\TriggerNotification;
use App\Services\TravelDistance\Address;
use App\Services\TravelDistance\ArrivalTime;
use App\Services\TravelDistance\TravelDistanceCalculator;
use App\Services\TravelDistance\TravelMode;
use App\Transfers\TriggerTypeId;
use Arr;

class TimeToLeaveTriggersProcessor
{
    public const HOURS_BEFORE = 4;
    private const MINUTES_BEFORE = 15;

    public function __construct(private readonly TravelDistanceCalculator $calculator)
    {
    }

    public function __invoke(Trigger $trigger): void
    {
        if ($trigger->trigger_type_id !== TriggerTypeId::TimeToLeave->value) {
            return;
        }

        $arrivalTime = ArrivalTime::fromTimeFormatted($trigger->configuration['fields']['arrival_time']);

        if ($arrivalTime->date->addHours(self::HOURS_BEFORE)->endOfMinute()->isPast()) {
            return;
        }

        $travelDistance = $this->calculator->calculate(
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
