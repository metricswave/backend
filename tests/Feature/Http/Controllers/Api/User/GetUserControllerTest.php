<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\actingAs;

it('return current user', function () {
    $user = User::factory()->create();
    actingAs($user)
        ->getJson('/api/users')
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->has('data', fn(AssertableJson $json) => $json
                ->hasAll([
                    'id',
                    'name',
                    'email',
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
