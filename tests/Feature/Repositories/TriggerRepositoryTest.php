<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use App\Repositories\TriggerRepository;
use App\Transfers\Time;
use App\Transfers\TriggerTypeId;
use App\Transfers\Weekday;

it('return expected trigger list', function () {
    $user = User::factory()->create();
    $triggerType = TriggerType::factory()->create(['id' => TriggerTypeId::OnTime]);
    Trigger::factory()->for($user)->for($triggerType)->create([
        'configuration' => [
            'fields' => [
                'time' => '08:00',
                'weekdays' => '["monday","tuesday","wednesday","thursday","friday"]',
            ]
        ],
    ]);
    Trigger::factory()->for($user)->for($triggerType)->create([
        'configuration' => [
            'fields' => [
                'time' => '08:00',
                'weekdays' => '["tuesday","wednesday","thursday","friday"]',
            ]
        ],
    ]);
    Trigger::factory()->for($user)->for($triggerType)->create([
        'configuration' => [
            'fields' => [
                'time' => '08:01',
                'weekdays' => '["monday","tuesday","wednesday","thursday","friday"]',
            ]
        ],
    ]);

    $result = (new TriggerRepository())
        ->onTimeFor(new Time('08:00'), new Weekday(Date::now()->startOfWeek()->dayOfWeek));

    expect($result->count())->toBe(1);
});
