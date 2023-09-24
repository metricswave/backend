<?php

use MetricsWave\Channels\Channel;
use MetricsWave\Channels\TeamChannel;
use MetricsWave\Teams\Team;

use function Pest\Laravel\actingAs;

it('delete expected team channel', function () {
    [$user, $team] = user_with_team();
    $channel = Channel::factory()->create();
    $teamChannel = TeamChannel::factory()->create([
        'team_id' => $team->id,
        'channel_id' => $channel->id,
    ]);

    actingAs($user)
        ->deleteJson("/api/teams/{$team->id}/channels/{$teamChannel->id}")
        ->assertNoContent();

    expect(TeamChannel::find($teamChannel->id))->toBeNull();
});

it('tries to delete a team channel with no access', function () {
    [$user, $team] = user_with_team();
    $otherTeam = Team::factory()->create();
    $channel = Channel::factory()->create();
    $teamChannel = TeamChannel::factory()->create([
        'team_id' => $otherTeam->id,
        'channel_id' => $channel->id,
    ]);

    actingAs($user)
        ->deleteJson("/api/teams/{$team->id}/channels/{$teamChannel->id}")
        ->assertForbidden();
});
