<?php

it('update an existing dashboard', function () {
    $dashboard = dashboard();

    $this->actingAs($dashboard->owner)
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
                [
                    'eventUuid' => $this->faker->uuid,
                    'title' => $this->faker->word,
                    'size' => 'large',
                    'type' => 'parameter',
                    'otherEvents' => [$this->faker->uuid],
                ],
            ],
        ])
        ->assertNoContent();

    expect($dashboard->refresh())
        ->name->toBe('New name')
        ->items->toHaveCount(3);
});
