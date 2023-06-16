<?php

use App\Models\Dashboard;
use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\getJson;

it('return triggers list', function () {
    $user = User::factory()->create();
    $dashboard = Dashboard::factory()
        ->for($user)
        ->create([
            'public' => true,
        ]);
    $trigger = Trigger::factory()
        ->for(TriggerType::factory()->create())
        ->for($user)
        ->create([
            'uuid' => $dashboard->items->first()->eventUuid,
        ]);

    getJson('/api/dashboards/'.$dashboard->uuid.'/triggers')
        ->assertOk()
        ->assertJson(fn(AssertableJson $json) => $json
            ->where('data.0.uuid', $trigger->uuid)
        );
});
