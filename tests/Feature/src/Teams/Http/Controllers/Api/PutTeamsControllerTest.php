<?php

use App\Models\Dashboard;
use MetricsWave\Teams\Team;

use function Pest\Laravel\actingAs;

it('update an owned team', function () {
    [$user, $team] = user_with_team();
    $dashboard = Dashboard::factory()->create(['name' => 'Default', 'team_id' => $team->id]);

    actingAs($user)
        ->putJson('/api/teams/'.$team->id, [
            'domain' => 'new-domain.com',
        ])
        ->assertNoContent();

    expect($team->fresh()->domain)->toBe('new-domain.com');

    expect($dashboard->fresh()->name)->toBe('Default');
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

it('update dashboard name depending on param', function () {
    [$user, $team] = user_with_team();
    $dashboard = Dashboard::factory()->create(['team_id' => $team->id]);

    actingAs($user)
        ->putJson('/api/teams/'.$team->id, [
            'domain' => 'new-domain.com',
            'change_dashboard_name' => true,
        ])
        ->assertNoContent();

    expect($dashboard->fresh()->name)->toBe('new-domain.com');
});
