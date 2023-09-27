<?php

use App\Models\Service;
use Illuminate\Testing\Fluent\AssertableJson;
use MetricsWave\Users\User;

use function Pest\Laravel\actingAs;

it('should return all services', function () {
    $user = User::factory()->create();
    Service::factory()->count(5)->create();

    actingAs($user)
        ->getJson('/api/services')
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) => $json
            ->count('data.services', 5)
            ->has('data.services.0', fn (AssertableJson $json) => $json
                ->whereType('id', 'integer')
                ->whereType('name', 'string')
                ->whereType('driver', 'string')
                ->whereType('description', 'string')
                ->whereType('configuration', 'array')
                ->whereType('multiple', 'boolean')
                ->whereType('scopes', 'array')
                ->whereType('created_at', 'string')
                ->whereType('updated_at', 'string')
            )
        );
});
