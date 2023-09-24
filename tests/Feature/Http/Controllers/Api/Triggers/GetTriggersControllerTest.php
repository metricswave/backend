<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use Illuminate\Testing\Fluent\AssertableJson;
use MetricsWave\Teams\Team;

use function Pest\Laravel\getJson;

it('should be able to get all triggers', function () {
    $triggerType = TriggerType::factory()->create();
    [$user, $team] = user_with_team();
    Trigger::factory()->for($team)->for($triggerType)->count(3)->create();

    $this->actingAs($user)
        ->getJson('/api/'.$team->id.'/triggers')
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) => $json
            ->count('data.triggers', 3)
            ->has('data.triggers.0', fn (AssertableJson $json) => $json
                ->has('id')
                ->has('team_id')
                ->has('trigger_type_id')
                ->has('uuid')
                ->has('emoji')
                ->has('title')
                ->has('content')
                ->has('configuration')
                ->has('trigger_type')
                ->has('via')
                ->has('created_at')
                ->has('deleted_at')
                ->has('updated_at')
                ->has('time')
                ->has('type')
                ->has('weekdays')
                ->has('arrival_time')
            ));
});

it('requires authentication', function () {
    $team = Team::factory()->create();

    getJson('/api/'.$team->id.'/triggers')
        ->assertUnauthorized();
});
