<?php

use App\Models\Team;
use App\Models\User;

it('return expected owned team relation', function () {
    $user = User::factory()->create();
    $team = Team::factory()->for($user, 'owner')->create();

    expect($user->refresh()->ownedTeams->first()->id)->toBe($team->id);
});
