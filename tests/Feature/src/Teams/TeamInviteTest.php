<?php

use MetricsWave\Teams\Mail\TeamInvitedMail;

use function Pest\Laravel\actingAs;

it('send invitation after been created', function () {
    Mail::fake();
    [$user, $team] = user_with_team();

    actingAs($user)
        ->postJson('/api/teams/'.$team->id.'/invites', [
            'email' => fake()->email,
        ])
        ->assertCreated();

    Mail::assertSent(TeamInvitedMail::class);
});
