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

    expect($visits)->toHaveCount(11);
});
