<?php

use App\Models\User;
use MetricsWave\Teams\Team;

it('return expected owned team relation', function () {
    $user = User::factory()->create();
    $team = Team::factory()->for($user, 'owner')->create();

    expect($user->refresh()->ownedTeams->first()->id)->toBe($team->id);
});
