<?php

use App\Models\User;
use MetricsWave\Teams\TeamInvite;

it('accepts an invitation', function () {
    $email = fake()->email;
    [$user, $team] = user_with_team();
    $invitedUser = User::factory()->create(['email' => $email]);
    $invite = TeamInvite::factory()->create([
        'team_id' => $team->id,
        'email' => $email,
    ]);

    $this->postJson('/api/teams/'.$team->id.'/invites/'.$invite->token.'/accept')
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

    $this->postJson('/api/teams/'.$team->id.'/invites/RANDOMTOKEN/accept')
        ->assertNotFound();
});

it('return 400 status if user does not exist', function () {
    $email = fake()->email;
    [$user, $team] = user_with_team();
    $invite = TeamInvite::factory()->create([
        'team_id' => $team->id,
        'email' => $email,
    ]);

    $this->postJson('/api/teams/'.$team->id.'/invites/'.$invite->token.'/accept')
        ->assertBadRequest();
});

it('assert user is not duplicated in group is accepted an invitation more than once', function () {
    $email = fake()->email;
    [$user, $team] = user_with_team();
    $user = User::factory()->create(['email' => $email]);
    $team->users()->attach($user);
    $invite = TeamInvite::factory()->create([
        'team_id' => $team->id,
        'email' => $email,
    ]);

    $this->postJson('/api/teams/'.$team->id.'/invites/'.$invite->token.'/accept')
        ->assertCreated();

    $this->assertDatabaseMissing('team_invites', [
        'team_id' => $team->id,
        'email' => $email,
    ]);

    assert($team->refresh()->users->count() === 1);
});
