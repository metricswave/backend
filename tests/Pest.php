<?php

use App\Models\Dashboard;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\WithFaker;
use MetricsWave\Teams\Team;
use MetricsWave\Users\User;

uses(LazilyRefreshDatabase::class)->in('Feature');

uses()->afterEach(function () {
    RefreshDatabaseState::$lazilyRefreshed = false;
    RefreshDatabaseState::$migrated = false;
})->in('Feature');

uses(Tests\TestCase::class, WithFaker::class)->in('Unit', 'Feature');

/**
 * @param  array<string, mixed>  $attributes
 * @return array{0: User, 1: Team}
 */
function user_with_team(array $attributes = [], array $teamAttributes = []): array
{
    $user = User::factory()->create($attributes);
    $team = Team::factory()->for($user, 'owner')->create($teamAttributes);

    return [$user, $team];
}

function dashboard($attributes = []): Dashboard
{
    [$user, $team] = user_with_team();

    return Dashboard::factory()->for($team)->create($attributes);
}
