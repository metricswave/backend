<?php

use App\Models\Dashboard;
use App\Models\User;

it('update an existing dashboard', function () {
    $user = User::factory()->create();
    $dashboard = Dashboard::factory()->for($user)->create();

    $this->actingAs($user)
        ->putJson('/api/dashboards/'.$dashboard->id, [
            'name' => 'New name',
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

    expect($dashboard->refresh())
        ->name->toBe('New name')
        ->items->toHaveCount(2);
});
