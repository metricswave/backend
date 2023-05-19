<?php

use App\Jobs\Calendar\UserServiceCalendarGetterJob;
use App\Models\Service;
use App\Models\User;
use App\Models\UserCalendar;
use App\Models\UserService;
use Tests\Feature\Services\Calendar\GoogleCalendarList;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseMissing;
use function Tests\Feature\Services\Calendar\fakeGoogleCalendarListApiCall;

it('store user calendars and remove not existing ones', function () {
    $user = User::factory()->create();
    $service = Service::factory()->create(['driver' => 'google']);
    UserService::factory()->for($user)->create([
        'service_id' => $service->id,
        'service_data' => ['token' => 'random valid token']
    ]);
    $shouldBeDeletedCal = UserCalendar::factory()->for($user)->for($service)->create();

    GoogleCalendarList::fake();

    UserServiceCalendarGetterJob::dispatchSync($user->services->first());

    assertDatabaseCount('user_calendars', 9);
    assertDatabaseMissing('user_calendars', ['id' => $shouldBeDeletedCal->id, 'deleted_at' => null]);
});
