<?php

use App\Models\User;

it("can impersonate a user", function () {
    $user = User::factory()->create(['id' => 1]);
    $userToImpersonate = User::factory()->create(['id' => 2]);

    $this->actingAs($user)
        ->postJson("/api/auth/impersonate", [
            'user_id' => $userToImpersonate->id,
            'device_name' => 'test',
        ])
        ->assertSuccessful();
});

it("return 404 if user id is not 1", function () {
    $user = User::factory()->create(['id' => 2]);
    $userToImpersonate = User::factory()->create(['id' => 5]);

    $this->actingAs($user)
        ->postJson("/api/auth/impersonate", [
            'user_id' => $userToImpersonate->id,
            'device_name' => 'test',
        ])
        ->assertNotFound();
});
