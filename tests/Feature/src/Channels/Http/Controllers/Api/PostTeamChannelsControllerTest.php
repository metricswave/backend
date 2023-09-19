<?php

use MetricsWave\Channels\Channel;
use MetricsWave\Teams\Team;

use function Pest\Laravel\actingAs;

it('create expected channel for team', function () {
    [$user, $team] = user_with_team();
    $channel = Channel::factory()->create();

    actingAs($user)
        ->postJson("/api/teams/{$team->id}/channels", [
            'channel_id' => $channel->id,
            'fields' => [
                'configuration' => [
                    'key' => 'value',
                ],
            ],
        ])
        ->assertCreated();
});

it('tries to create a channel for a team with no access', function () {
    [$user, $team] = user_with_team(attributes: ['id' => 4], teamAttributes: ['id' => 4]);
    $otherTeam = Team::factory()->create(['id' => 5]);
    $channel = Channel::factory()->create();

    actingAs($user)
        ->postJson("/api/teams/{$otherTeam->id}/channels", [
            'channel_id' => $channel->id,
            'fields' => [
                'configuration' => [
                    'key' => 'value',
                ],
            ],
        ])
        ->assertForbidden();
});
