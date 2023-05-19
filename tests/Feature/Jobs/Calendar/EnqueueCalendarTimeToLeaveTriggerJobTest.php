<?php

use App\Jobs\Calendar\EnqueueCalendarTimeToLeaveEventNotificationsJob;
use App\Jobs\Calendar\EnqueueCalendarTimeToLeaveTriggerJob;
use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use App\Transfers\TriggerTypeId;

it('will dispatch expected jobs for triggers', function () {
    $user = User::factory()->create();
    TriggerType::factory()->create(['id' => TriggerTypeId::TimeToLeave->value]);
    TriggerType::factory()->create(['id' => TriggerTypeId::CalendarTimeToLeave->value]);
    Trigger::factory()->for($user)->timeToLeave()->create();
    Trigger::factory()->for($user)->calendarTimeToLeave()->create();

    Queue::fake([
        EnqueueCalendarTimeToLeaveEventNotificationsJob::class,
    ]);

    EnqueueCalendarTimeToLeaveTriggerJob::dispatch();

    Queue::assertPushed(EnqueueCalendarTimeToLeaveEventNotificationsJob::class, 1);
});
