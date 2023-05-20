<?php

use App\Models\Service;
use App\Models\User;
use App\Models\UserService;
use App\Services\Calendar\Events;
use App\Services\Calendar\GoogleCalendarEventsGetter;
use Tests\Feature\Services\Calendar\GoogleCalendarUpcomingEvents;

it('return expected Events', function () {
    $user = User::factory()->create();
    $service = Service::factory()->create(['driver' => 'google']);
    UserService::factory()->for($user)->create([
        'service_id' => $service->id,
        'service_data' => ['token' => 'random valid token']
    ]);

    GoogleCalendarUpcomingEvents::fake();

    $response = app()->get(GoogleCalendarEventsGetter::class)->incoming($user, 'valid-cal-id');

    expect($response)->toBeInstanceOf(Events::class)
        ->and($response->items())->toHaveCount(10)
        ->and($response->items()->first())->toBeInstanceOf(\App\Services\Calendar\Event::class)
        ->id->toBe('_611k2e9m84q46ba484sk6b9k88ok8b9o6or3ab9i8d14agi568s32dhg84')
        ->summary->toBe('Padel ')
        ->location->toBe('Euroindoor Alcorcón')
        ->startAt()->toAtomString()->toBe('2023-05-20T12:30:00+00:00');
});
