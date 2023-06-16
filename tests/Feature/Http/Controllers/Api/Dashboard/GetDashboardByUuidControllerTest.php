<?php

use App\Models\Dashboard;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\getJson;

it('return public dashboard', function () {
    $dashboard = Dashboard::factory()
        ->for(User::factory()->create())
        ->create([
            'public' => true,
        ]);

    getJson("/api/dashboards/{$dashboard->uuid}")
        ->assertOk()
        ->assertJson(fn(AssertableJson $json) => $json
            ->hasAll([
                'data.name',
                'data.public',
                'data.uuid',
                'data.user_id',
                'data.items',
            ])
        );
});

it('return 404 when dashboard is not public', function () {
    $dashboard = Dashboard::factory()
        ->for(User::factory()->create())
        ->create([
            'public' => false,
        ]);

    getJson("/api/dashboards/{$dashboard->uuid}")
        ->assertNotFound();
});
