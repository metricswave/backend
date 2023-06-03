<?php

use App\Jobs\Calendar\CalendarTimeToLeaveTriggerNotificationJob;
use App\Jobs\Calendar\EnqueueCalendarTimeToLeaveEventNotificationsJob;
use App\Models\Service;
use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use App\Models\UserCalendar;
use App\Models\UserService;
use App\Transfers\ServiceId;
use App\Transfers\TriggerTypeId;
use Tests\Feature\Services\Calendar\GoogleCalendarUpcomingEvents;

it('should enqueue CalendarTimeToLeaveTriggerNotificationJob', function () {
    $user = User::factory()->create();
    $service = Service::factory()->create(['id' => ServiceId::Google->value, 'driver' => 'google']);
    UserService::factory()->for($user)->createQuietly([
        'service_id' => $service->id,
        'service_data' => ['token' => 'random valid token']
    ]);
    TriggerType::factory()->create(['id' => TriggerTypeId::CalendarTimeToLeave->value]);
    $trigger = Trigger::factory()->for($user)->calendarTimeToLeave()->create();
    UserCalendar::factory()->for($user)->create(['calendar_id' => 'valid-cal-id']);

    GoogleCalendarUpcomingEvents::fake();
    Queue::fake([
        CalendarTimeToLeaveTriggerNotificationJob::class,
    ]);

    EnqueueCalendarTimeToLeaveEventNotificationsJob::dispatch($trigger);

    Queue::assertPushed(CalendarTimeToLeaveTriggerNotificationJob::class, function ($job) use ($trigger) {
        return get_private_property($job, 'trigger')->id === $trigger->id;
    });
});
