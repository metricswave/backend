<?php

use App\Models\User;
use App\Models\UserService;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\actingAs;

it('should return 200', function () {
    $user = User::factory()->create();
    UserService::factory()->for($user)->create();

    actingAs($user)
        ->getJson('/api/users/services')
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->count('data.services', 1)
            ->has('data.services.0', fn(AssertableJson $json) => $json
                ->whereType('id', 'integer')
                ->whereType('user_id', 'integer')
                ->whereType('service_id', 'string')
                ->whereType('service_data', 'array')
                ->whereType('created_at', 'string')
                ->whereType('updated_at', 'string')
                ->etc()
            ));
});

it('should return 401', function () {
    $this->getJson('/api/users/services')
        ->assertUnauthorized();
});
