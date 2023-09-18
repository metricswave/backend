<?php

use App\Models\Price;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\actingAs;

it('return current user', function () {
    Price::factory()->create(['id' => '1', 'type' => 'monthly', 'price' => 1000]);
    [$user, $team] = user_with_team(teamAttributes: ['price_id' => 1]);

    actingAs($user)
        ->getJson('/api/users')
        ->assertSuccessful()
        ->dump()
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->hasAll([
                    'id',
                    'name',
                    'email',
                    'all_teams',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ])
            )
        );
});

it('return error if not authenticated')
    ->getJson('/api/users')
    ->assertUnauthorized();
