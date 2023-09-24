<?php

use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\getJson;

it('return public dashboard', function () {
    $dashboard = dashboard(['public' => true]);

    getJson("/api/dashboards/{$dashboard->uuid}")
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json
            ->hasAll([
                'data.name',
                'data.public',
                'data.uuid',
                'data.team_id',
                'data.items',
            ])
        );
});

it('return 404 when dashboard is not public', function () {
    $dashboard = dashboard(['public' => false]);

    getJson("/api/dashboards/{$dashboard->uuid}")
        ->assertNotFound();
});
