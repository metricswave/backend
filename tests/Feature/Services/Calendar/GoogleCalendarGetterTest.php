<?php

use App\Models\Service;
use App\Models\User;
use App\Models\UserService;
use App\Services\Calendar\Calendars;
use App\Services\Calendar\GoogleCalendarGetter;
use App\Transfers\ServiceId;
use Tests\Feature\Services\Calendar\GoogleCalendarList;
use function Tests\Feature\Services\Calendar\fakeGoogleCalendarListApiCall;

it('return expected Calendars', function () {
    $user = User::factory()->create();
    $service = Service::factory()->create(['id' => ServiceId::Google->value, 'driver' => 'google']);
    UserService::factory()->for($user)->createQuietly([
        'service_id' => $service->id,
        'service_data' => ['token' => 'random valid token']
    ]);

    GoogleCalendarList::fake();

    $calendars = app()->get(GoogleCalendarGetter::class)->all($user);

    expect($calendars)->toBeInstanceOf(Calendars::class)
        ->and($calendars->items())->toHaveCount(8)
        ->and($calendars->items()->first())
        ->id->toBe('q1a2alu219e1tofg74k4p87vuk@group.calendar.google.com')
        ->name->toBe('Deporte')
        ->description->toBeNull()
        ->foregroundColor->toBe('#000000')
        ->backgroundColor->toBe('#42d0f4')
        ->timeZone->toBe('Europe/Madrid');
});
