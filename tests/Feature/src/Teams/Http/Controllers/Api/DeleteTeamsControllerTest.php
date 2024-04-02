<?php

use MetricsWave\Teams\Team;

use function Pest\Laravel\actingAs;

it('delete an owned team', function () {
    [$user, $team] = user_with_team();
    $secondTeam = Team::factory()->create(['owner_id' => $user->id]);

    actingAs($user)
        ->deleteJson('/api/teams/'.$secondTeam->id)
        ->assertNoContent();

    expect($secondTeam->fresh()->trashed())->toBe(true);
});

it('return 403 when updating a team you do not own', function () {
    [$user, $team] = user_with_team();
    $otherTeam = Team::factory()->create();

    actingAs($user)
        ->deleteJson('/api/teams/'.$otherTeam->id)
        ->assertForbidden();
});

it('return 400 because your are trying to remove your last team', function () {
    [$user, $team] = user_with_team();

    actingAs($user)
        ->deleteJson('/api/teams/'.$team->id)
        ->assertBadRequest();
});
