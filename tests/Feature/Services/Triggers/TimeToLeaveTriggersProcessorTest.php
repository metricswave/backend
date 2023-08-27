<?php

use App\Jobs\UserTriggerNotificationJob;
use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use App\Services\TravelDistance\TravelMode;
use App\Services\Triggers\TimeToLeaveTriggersProcessor;
use App\Transfers\TriggerTypeId;
use App\Transfers\Weekday;

it('should process time to leave trigger', function () {
    Queue::fake();

    $trigger = Trigger::factory()
        ->for(User::factory()->create())
        ->for(TriggerType::factory()->create(['id' => TriggerTypeId::TimeToLeave->value]))
        ->createQuietly([
            'configuration' => [
                'fields' => [
                    'origin' => 'Calle Oca 21, Madrid, España',
                    'destination' => 'San Pantaleón 5, Madrid, España',
                    'mode' => TravelMode::DRIVING->value,
                    'arrival_time' => now()->subHours(TimeToLeaveTriggersProcessor::HOURS_BEFORE)->format('H:i'),
                    'weekdays' => [Weekday::fromDayOfWeek(now()->dayOfWeek)->toString()],
                ],
            ],
        ]);

    app()->get(TimeToLeaveTriggersProcessor::class)($trigger);

    Queue::assertPushed(UserTriggerNotificationJob::class, function ($job) use ($trigger) {
        return get_private_property($job, 'user')->id === $trigger->user->id;
    });
});
