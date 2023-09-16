<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

it('return default dashboard if user has not any', function () {
    $this->actingAs(User::factory()->create());

    $this->getJson('/api/dashboards')
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
