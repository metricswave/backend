<?php

use MetricsWave\Teams\TeamInvite;

it('create expected invitation', function () {
    [$user, $team] = user_with_team();
    $email = fake()->email;

    $this->actingAs($user)
        ->postJson('/api/teams/'.$team->id.'/invites', [
            'email' => $email,
        ])
        ->assertCreated();

    $this->assertDatabaseHas('team_invites', [
        'team_id' => $team->id,
        'email' => $email,
    ]);
});

it('fails when email is already invited', function () {
    $email = fake()->email;
    [$user, $team] = user_with_team();
    TeamInvite::factory()->create([
        'team_id' => $team->id,
        'email' => $email,
    ]);

    $this->actingAs($user)
        ->postJson('/api/teams/'.$team->id.'/invites', [
            'email' => $email,
        ])
        ->assertUnprocessable();
});
