<?php

use App\Models\Dashboard;
use App\Models\User;
use MetricsWave\Teams\Team;

use function Pest\Laravel\assertDatabaseCount;

it('delete an existing dashboard', function () {
    $user = User::factory()->create();
    $team = Team::factory()->for($user, 'owner')->create();
    $dashboard = Dashboard::factory()->for($team)->create();

    $this->actingAs($user)
        ->deleteJson('/api/dashboards/'.$dashboard->id, [])
        ->assertNoContent();

    assertDatabaseCount('dashboards', 0);
});
