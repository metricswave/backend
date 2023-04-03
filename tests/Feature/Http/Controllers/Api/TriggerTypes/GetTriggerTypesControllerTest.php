<?php

use App\Models\TriggerType;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

it('returns a list of trigger types', function () {
    $user = User::factory()->create();
    TriggerType::factory()->count(3)->create();

    $this->actingAs($user)
        ->getJson('/api/trigger-types')
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->count('data.trigger_types', 3)
            ->has('data.trigger_types.0', fn(AssertableJson $json) => $json
                ->has('id')
                ->has('name')
                ->has('description')
                ->has('icon')
                ->has('configuration')
                ->has('created_at')
                ->has('updated_at')
            )
        );
});

it('requires authentication')
    ->getJson('/api/trigger-types')
    ->assertUnauthorized();
