<?php

use Illuminate\Testing\Fluent\AssertableJson;

it('return default dashboard if user has not any', function () {
    [$user, $team] = user_with_team();

    $this->actingAs($user)
        ->getJson('/api/'.$team->id.'/dashboards')
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json
            ->count('data', 1)
            ->has('data.0', fn (AssertableJson $json) => $json
                ->where('id', 1)
                ->where('team_id', 1)
                ->where('name', 'Default')
                ->where('items', [])
                ->etc()
            )
        );
});
