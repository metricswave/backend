<?php

use App\Models\Dashboard;

it('create a new dashboard', function () {
    [$user, $team] = user_with_team();

    $this->actingAs($user)
        ->postJson('/api/'.$team->id.'/dashboards/', [
            'name' => 'New name',
            'public' => false,
            'items' => [
                [
                    'eventUuid' => $this->faker->uuid,
                    'title' => $this->faker->word,
                    'size' => 'base',
                    'type' => 'stats',
                ],
                [
                    'eventUuid' => $this->faker->uuid,
                    'title' => $this->faker->word,
                    'size' => 'large',
                    'type' => 'parameter',
                    'parameter' => $this->faker->word,
                ],
            ],
        ])
        ->assertNoContent();

    $dashboard = Dashboard::where('team_id', $team->id)->where('name', 'New name')->first();

    expect($dashboard)
        ->name->toBe('New name')
        ->team_id->toBe($team->id)
        ->uuid->toBeString()
        ->public->toBeFalse()
        ->items->toHaveCount(2);
});

it('create a new dashboard without items', function () {
    [$user, $team] = user_with_team();

    $this->actingAs($user)
        ->postJson('/api/'.$team->id.'/dashboards/', [
            'name' => 'New name',
            'items' => [],
        ])
        ->assertNoContent();

    $dashboard = Dashboard::where('team_id', $team->id)->where('name', 'New name')->first();

    expect($dashboard)
        ->name->toBe('New name')
        ->team_id->toBe($team->id)
        ->uuid->toBeString()
        ->public->toBeFalse()
        ->items->toHaveCount(0);
});
