<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\actingAs;

it('return teams with users', function () {
    [$user, $team] = user_with_team();
    [$otherUser, $otherTeam] = user_with_team();
    $team->users()->attach(User::factory()->count(6)->create()->pluck('id')->toArray());
    $otherTeam->users()->attach($user);

    actingAs($user)
        ->getJson('/api/teams')
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data.0.owner')
            ->count('data.0.users', 6)
            ->where('data.0.limits.soft', false)
            ->where('data.0.limits.hard', false)
        );
});
