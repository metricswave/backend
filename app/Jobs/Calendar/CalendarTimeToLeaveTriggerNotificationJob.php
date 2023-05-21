<?php

namespace App\Jobs\Calendar;

use App\Jobs\UserTriggerNotificationJob;
use App\Models\Trigger;
use App\Models\UserCalendar;
use App\Notifications\TriggerNotification;
use App\Services\Calendar\Event;
use App\Services\Calendar\EventsGetter;
use App\Services\TravelDistance\Address;
use App\Services\TravelDistance\ArrivalTime;
use App\Services\TravelDistance\TravelDistanceCalculator;
use App\Services\TravelDistance\TravelMode;
use App\Services\Triggers\TimeToLeaveTriggersProcessor;
use Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * @method static PendingDispatch dispatch(Trigger $trigger, UserCalendar $calendar, Event $event)
 * @method static PendingDispatch dispatchSync(Trigger $trigger, UserCalendar $calendar, Event $event)
 */
class CalendarTimeToLeaveTriggerNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly Trigger $trigger,
        private readonly UserCalendar $calendar,
        private readonly Event $event,
    ) {
    }

    public function handle(EventsGetter $eventsGetter, TravelDistanceCalculator $calculator): void
    {
        try {
            $event = $eventsGetter->find(
                $this->trigger->user,
                $this->calendar->calendar_id,
                $this->event->id,
            );
        } catch (RequestException) {
            return;
        }

        if (!$event->startAt()->equalTo($this->event->startAt())) {
            return;
        }

        if ($event->location === null) {
            return;
        }

        $arrivalTime = new ArrivalTime($event->startAt());

        $travelDistance = $calculator->calculate(
            new Address($this->trigger->configuration['fields']['origin']),
            new Address($event->location),
            TravelMode::from($this->trigger->configuration['fields']['mode']),
            $arrivalTime,
        );

        $notification = new TriggerNotification(
            $this->trigger,
            Arr::dot([
                ...$travelDistance->toArray(),
                'event' => $event->notificationData(),
            ])
        );

        UserTriggerNotificationJob::dispatch($this->trigger->user, $notification)
            ->delay(
                $arrivalTime->date()
                    ->subSeconds($travelDistance->duration->seconds)
                    ->subMinutes(TimeToLeaveTriggersProcessor::MINUTES_BEFORE)
            );
    }
}
