<?php

use App\Jobs\Calendar\UserServiceCalendarGetterJob;
use App\Models\Service;
use App\Models\User;
use App\Models\UserCalendar;
use App\Models\UserService;
use App\Transfers\ServiceId;
use Tests\Feature\Services\Calendar\GoogleCalendarList;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseMissing;

it('store user calendars and remove not existing ones', function () {
    $user = User::factory()->create();
    $service = Service::factory()->create(['id' => ServiceId::Google->value, 'driver' => 'google']);
    UserService::factory()->for($user)->createQuietly([
        'service_id' => $service->id,
        'service_data' => ['token' => 'random valid token']
    ]);
    $shouldBeDeletedCal = UserCalendar::factory()->for($user)->for($service)->create();

    GoogleCalendarList::fake();

    UserServiceCalendarGetterJob::dispatchSync($user->services->first());

    assertDatabaseCount('user_calendars', 9);
    assertDatabaseMissing('user_calendars', ['id' => $shouldBeDeletedCal->id, 'deleted_at' => null]);
});
