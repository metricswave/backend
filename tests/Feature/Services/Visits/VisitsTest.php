<?php

use App\Models\User;
use Awssat\Visits\Models\Visit;

it('increase visits and set expired_at dates as expected', function () {
    $user = User::factory()->create();

    $startDate = Date::createFromDate('1989', '10', '23')->startOfDay()->subDay();
    $this->travelTo($startDate);
    $user->triggerNotificationVisits()->increment();

    foreach (range(1, 5) as $i) {
        $this->travelTo($startDate->addRealDay());
        $user->triggerNotificationVisits()->increment();
    }

    $visits = Visit::query()->where('secondary_key', $user->id)->get([
        'primary_key',
        'expired_at',
        'score',
    ])->toArray();

    expect($visits)->dump()->toHaveCount(11);
});

it('fails because unique index violation', function () {
    $user = User::factory()->create();

    Visit::create([
        'primary_key' => 'visits:testing:users_triggernotification_day',
        'secondary_key' => 1,
        'score' => 10,
        'expired_at' => now()->addDay()->startOfDay(),
    ]);

    Visit::create([
        'primary_key' => 'visits:testing:users_triggernotification_day',
        'secondary_key' => 1,
        'score' => 10,
        'expired_at' => null,
    ]);

    $user->triggerNotificationVisits()->increment();

    $visits = Visit::query()
        ->where('primary_key', 'visits:testing:users_triggernotification_day')
        ->where('secondary_key', $user->id)->get([
            'primary_key',
            'expired_at',
            'score',
        ])->toArray();

    expect($visits)->toBe([
        [
            'primary_key' => 'visits:testing:users_triggernotification_day',
            'expired_at' => now()->addDay()->startOfDay()->toIso8601ZuluString('microseconds'),
            'score' => 21,
        ],
    ]);
});
