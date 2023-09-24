<?php

use MetricsWave\Teams\TeamInvite;

it('delete the already created invitation', function () {
    $email = fake()->email;
    [$user, $team] = user_with_team();
    $invite = TeamInvite::factory()->create([
        'team_id' => $team->id,
        'email' => $email,
    ]);

    $this->actingAs($user)
        ->deleteJson('/api/teams/'.$team->id.'/invites/'.$invite->id)
        ->assertNoContent();

    $this->assertDatabaseMissing('team_invites', [
        'team_id' => $team->id,
        'email' => $email,
    ]);
});

it('gives a no content response even when the invitation is not created', function () {
    [$user, $team] = user_with_team();

    $this->actingAs($user)
        ->deleteJson('/api/teams/'.$team->id.'/invites/2')
        ->assertNotFound();
});
