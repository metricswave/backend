<?php

use MetricsWave\Channels\Channel;
use MetricsWave\Channels\TeamChannel;

use function Pest\Laravel\actingAs;

it('return team channels', function () {
    [$user, $team] = user_with_team();
    $channel = Channel::factory()->create();
    TeamChannel::factory()->create([
        'team_id' => $team->id,
        'channel_id' => $channel->id,
    ]);

    actingAs($user)
        ->getJson("/api/teams/{$team->id}/channels")
        ->assertOk()
        ->assertJsonCount(1, 'data');
});
