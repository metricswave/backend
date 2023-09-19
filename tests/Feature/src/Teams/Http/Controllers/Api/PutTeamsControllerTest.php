<?php

use MetricsWave\Teams\Team;

use function Pest\Laravel\actingAs;

it('update an owned team', function () {
    [$user, $team] = user_with_team();

    actingAs($user)
        ->putJson('/api/teams/'.$team->id, [
            'domain' => 'new-domain.com',
        ])
        ->assertNoContent();

    expect($team->fresh()->domain)->toBe('new-domain.com');
});

it('return 403 when updating a team you do not own', function () {
    [$user, $team] = user_with_team();
    $otherTeam = Team::factory()->create();

    actingAs($user)
        ->putJson('/api/teams/'.$otherTeam->id, [
            'domain' => 'new-domain.com',
        ])
        ->assertForbidden();
});
