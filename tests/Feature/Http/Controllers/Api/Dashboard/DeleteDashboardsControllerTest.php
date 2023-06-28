<?php

use App\Models\Dashboard;
use App\Models\User;
use function Pest\Laravel\assertDatabaseCount;

it('delete an existing dashboard', function () {
    $user = User::factory()->create();
    $dashboard = Dashboard::factory()->for($user)->create();

    $this->actingAs($user)
        ->deleteJson('/api/dashboards/'.$dashboard->id, [])
        ->assertNoContent();

    assertDatabaseCount('dashboards', 0);
});
