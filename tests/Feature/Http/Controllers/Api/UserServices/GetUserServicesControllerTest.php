<?php

use Illuminate\Testing\Fluent\AssertableJson;
use MetricsWave\Users\User;
use MetricsWave\Users\UserService;

it('should return 200', function () {
    $user = User::factory()->create();
    UserService::factory()->for($user)->create();

    $this->actingAs($user)
        ->getJson('/api/users/services')
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) => $json
            ->count('data.services', 1)
            ->has('data.services.0', fn (AssertableJson $json) => $json
                ->whereType('id', 'integer')
                ->whereType('service_id', 'integer')
                ->whereType('user_id', 'integer')
                ->whereType('service_data', 'array')
                ->whereType('created_at', 'string')
                ->whereType('updated_at', 'string')
                ->whereType('deleted_at', 'null')
                ->etc()
            ));
});

it('should return 401', function () {
    $this->getJson('/api/users/services')
        ->assertUnauthorized();
});
