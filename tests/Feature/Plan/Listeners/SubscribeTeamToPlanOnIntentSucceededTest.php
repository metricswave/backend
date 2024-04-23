<?php

use App\Models\User;
use App\Services\Plans\PlanGetter;
use MetricsWave\Plan\Listeners\SubscribeTeamToPlanOnIntentSucceeded;
use MetricsWave\Teams\Team;

it('creates expected subscription with payment method', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    $plan = app(PlanGetter::class)->paidPlans()->first();

    app(SubscribeTeamToPlanOnIntentSucceeded::class)
        ->handle(
            $team->id,
            $plan->id->value,
            'eur',
            'pm_1P8kPUDpKR4Se5u8VANGdf86',
        );

    $team->refresh();

    dd(
        $team->defaultPaymentMethod(),
        $team->subscriptions
    );
})->skip(message: "Only for manual testings. It requires an stripe payment method.");
