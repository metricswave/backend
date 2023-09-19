<?php

use App\Models\User;
use MetricsWave\Channels\Channel;

use function Pest\Laravel\actingAs;

it('return expected channels', function () {
    $user = User::factory()->create();
    Channel::factory()->count(3)->create();

    actingAs($user)
        ->getJson('/api/channels')
        ->assertOk()
        ->assertJsonCount(3, 'data');
});
