<?php

use App\Jobs\Calendar\CalendarTimeToLeaveTriggerNotificationJob;
use App\Jobs\UserTriggerNotificationJob;
use App\Models\Service;
use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use App\Models\UserCalendar;
use App\Models\UserService;
use App\Notifications\TriggerNotification;
use App\Services\Calendar\Event;
use App\Transfers\TriggerTypeId;
use Illuminate\Support\Carbon;
use Tests\Feature\Services\Calendar\GoogleCalendarEventFind;

it('enqueue UserTriggerNotificationJob', function () {
    $user = User::factory()->create();
    $service = Service::factory()->create(['driver' => 'google']);
    UserService::factory()->for($user)->create([
        'service_id' => $service->id,
        'service_data' => ['token' => 'random valid token']
    ]);
    TriggerType::factory()->create(['id' => TriggerTypeId::CalendarTimeToLeave->value]);
    $trigger = Trigger::factory()->for($user)->calendarTimeToLeave()->create();
    $userCalendar = UserCalendar::factory()->for($user)->create(['calendar_id' => 'valid-cal-id']);
    $event = new Event(
        '_611k2e9m84q46ba484sk6b9k88ok8b9o6or3ab9i8d14agi568s32dhg84',
        'Padel',
        'EuroIndoor Alcorcón',
        Carbon::parse('2023-05-19T11:00:00+02:00'),
        isAllDay: false,
        isConfirmed: true,
    );

    Queue::fake([UserTriggerNotificationJob::class]);
    GoogleCalendarEventFind::fakeWith($userCalendar, $event);

    CalendarTimeToLeaveTriggerNotificationJob::dispatch($trigger, $userCalendar, $event);

    Queue::assertPushed(UserTriggerNotificationJob::class,
        function (UserTriggerNotificationJob $job) use ($user, $trigger, $event) {
            return get_private_property($job, 'user')->is($user)
                && get_private_property($job, 'notification') instanceof TriggerNotification;
        });
});

it("don't enqueue UserTriggerNotificationJob because event was deleted", function () {
    $user = User::factory()->create();
    $service = Service::factory()->create(['driver' => 'google']);
    UserService::factory()->for($user)->create([
        'service_id' => $service->id,
        'service_data' => ['token' => 'random valid token']
    ]);
    TriggerType::factory()->create(['id' => TriggerTypeId::CalendarTimeToLeave->value]);
    $trigger = Trigger::factory()->for($user)->calendarTimeToLeave()->create();
    $userCalendar = UserCalendar::factory()->for($user)->create(['calendar_id' => 'valid-cal-id']);
    $event = new Event(
        '_611k2e9m84q46ba484sk6b9k88ok8b9o6or3ab9i8d14agi568s32dhg84',
        'Padel',
        'EuroIndoor Alcorcón',
        Carbon::parse('2023-05-19T11:00:00+02:00'),
        isAllDay: false,
        isConfirmed: true,
    );

    Queue::fake([UserTriggerNotificationJob::class]);
    GoogleCalendarEventFind::fakeNoFoundWith($userCalendar, $event);

    CalendarTimeToLeaveTriggerNotificationJob::dispatch($trigger, $userCalendar, $event);

    Queue::assertNothingPushed();
});

it("don't enqueue UserTriggerNotificationJob because location was deleted", function () {
})->todo();

it("don't enqueue UserTriggerNotificationJob because start at time changed", function () {
})->todo();
