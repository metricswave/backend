<?php

use App\Models\User;
use MetricsWave\Teams\TeamInvite;

use function Pest\Laravel\actingAs;

it('accepts an invitation', function () {
    $email = fake()->email;
    [$user, $team] = user_with_team();
    $invitedUser = User::factory()->create(['email' => $email]);
    $invite = TeamInvite::factory()->create([
        'team_id' => $team->id,
        'email' => $email,
    ]);

    actingAs($user)
        ->postJson('/api/teams/'.$team->id.'/invites/'.$invite->token.'/accept')
        ->assertCreated();

    $this->assertDatabaseMissing('team_invites', [
        'team_id' => $team->id,
        'email' => $email,
    ]);

    $this->assertDatabaseHas('team_user', [
        'team_id' => $team->id,
        'user_id' => $invitedUser->id,
    ]);
});

it('return not found if random token', function () {
    $email = fake()->email;
    [$user, $team] = user_with_team();
    User::factory()->create(['email' => $email]);
    $invite = TeamInvite::factory()->create([
        'team_id' => $team->id,
        'email' => $email,
    ]);

    actingAs($user)
        ->postJson('/api/teams/'.$team->id.'/invites/RANDOMTOKEN/accept')
        ->assertNotFound();
});
