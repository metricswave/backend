<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use MetricsWave\Channels\Channel;

use function Pest\Laravel\actingAs;

it('return expected channels', function () {
    $user = User::factory()->create();
    Channel::factory()->count(3)->create();

    actingAs($user)
        ->getJson('/api/channels')
        ->assertOk()
        ->assertJsonCount(3, 'data')
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data.0', fn (AssertableJson $json) => $json
                ->whereType('id', 'integer')
                ->whereType('name', 'string')
                ->whereType('driver', 'string')
                ->whereType('description', 'string')
                ->whereType('configuration', 'array')
                ->whereType('created_at', 'string')
                ->whereType('updated_at', 'string')
            )
        );
});
