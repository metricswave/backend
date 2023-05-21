<?php

namespace App\Jobs\Calendar;

use App\Models\Trigger;
use App\Services\CacheKey;
use App\Services\Calendar\EventsGetter;
use App\Services\Triggers\TimeToLeaveTriggersProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

/**
 * @method static PendingDispatch dispatch(Trigger $trigger)
 * @method static PendingDispatch dispatchSync(Trigger $trigger)
 */
class EnqueueCalendarTimeToLeaveEventNotificationsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly Trigger $trigger,
    ) {
    }

    public function handle(EventsGetter $eventsGetter): void
    {
        $hoursBefore = TimeToLeaveTriggersProcessor::HOURS_BEFORE;

        foreach ($this->trigger->user->calendars as $calendar) {
            $events = $eventsGetter->incoming(
                $this->trigger->user,
                $calendar->calendar_id,
            );

            foreach ($events->items() as $event) {
                if ($event->location === null) {
                    continue;
                }

                if ($event->startAt()->isPast()) {
                    continue;
                }

                if ($event->isAllDay) {
                    continue;
                }

                $cacheKey = CacheKey::generate('events', $event->id, [
                    'trigger',
                    $this->trigger->id,
                    'startAt',
                    $event->startAt()->toIso8601String(),
                ]);

                if (Cache::has($cacheKey)) {
                    continue;
                }

                CalendarTimeToLeaveTriggerNotificationJob::dispatch(
                    $this->trigger,
                    $calendar,
                    $event,
                )->delay(
                    $event->startAt()->subHours($hoursBefore),
                );

                Cache::put(
                    $cacheKey,
                    true,
                    $event->startAt(),
                );
            }
        }
    }
}
