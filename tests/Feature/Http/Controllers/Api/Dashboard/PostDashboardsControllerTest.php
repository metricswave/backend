<?php

use App\Models\Dashboard;
use App\Models\User;

it('create a new dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson('/api/dashboards/', [
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

    expect(Dashboard::find(1))
        ->name->toBe('New name')
        ->uuid->toBeString()
        ->public->toBeFalse()
        ->items->toHaveCount(2);
});

it('create a new dashboard without items', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson('/api/dashboards/', [
            'name' => 'New name',
            'items' => [],
        ])
        ->assertNoContent();

    expect(Dashboard::find(1))
        ->name->toBe('New name')
        ->uuid->toBeString()
        ->public->toBeFalse()
        ->items->toHaveCount(0);
});
