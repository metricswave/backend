<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\getJson;

it('return triggers list', function () {
    $dashboard = dashboard(['public' => true]);
    $trigger = Trigger::factory()
        ->for(TriggerType::factory()->create())
        ->for($dashboard->owner, 'user')
        ->create([
            'uuid' => $dashboard->items->first()->eventUuid,
        ]);

    getJson('/api/dashboards/'.$dashboard->uuid.'/triggers')
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('data.0.uuid', $trigger->uuid)
        );
});
