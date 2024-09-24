<?php

use App\Models\Price;
use App\Transfers\PlanId;
use App\Transfers\SubscriptionType;

it('return expected owner', function () {
    [$user, $team] = user_with_team();

    expect($team->owner->id)->toBe($user->id)
        ->and($team->owner->email)->toBe($user->email);
});

it('return expected plan information', function () {
    Price::factory()->create(['id' => 4, 'type' => 'monthly', 'price' => 1000]);
    [,$team] = user_with_team(teamAttributes: ['price_id' => 4]);

    expect($team->subscription_status)->toBe(true)
        ->and($team->subscription_type)->toBe(SubscriptionType::Monthly)
        ->and($team->subscription_plan_id)->toBe(PlanId::BUSINESS);
});
