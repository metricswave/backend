<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

it('should be able to get all triggers', function () {
    $user = User::factory()->create();
    $triggerType = TriggerType::factory()->create();
    Trigger::factory()->for($user)->for($triggerType)->count(3)->create();

    $this->actingAs($user)
        ->getJson('/api/triggers')
        ->assertSuccessful()
        ->dump()
        ->assertJson(fn(AssertableJson $json) => $json
            ->count('data.triggers', 3)
            ->has('data.triggers.0', fn(AssertableJson $json) => $json
                ->has('id')
                ->has('user_id')
                ->has('trigger_type_id')
                ->has('uuid')
                ->has('emoji')
                ->has('title')
                ->has('content')
                ->has('configuration')
                ->has('trigger_type')
                ->has('created_at')
                ->has('updated_at')
            ));
});

it('requires authentication')
    ->getJson('/api/triggers')
    ->assertUnauthorized();
