<?php

namespace MetricsWave\Plan\Listeners;

use App\Services\Plans\PlanGetter;
use App\Transfers\PlanId;
use Laravel\Cashier\Events\WebhookReceived;
use MetricsWave\Teams\Team;

class SubscribeTeamToPlanOnIntentSucceeded
{
    public function __construct(
        private readonly PlanGetter $planGetter,
    ) {
    }

    public function handle(
        int $teamId,
        int $planId,
        string $currency,
        string $paymentMethodId,
    ): void
    {
        $team = Team::findOrFail($teamId);

        // $this->setUpDefaultPaymentMethod($team, $paymentMethodId);

        $this->subscribeToPlan($team, $planId, $currency, $paymentMethodId);
    }

    private function setUpDefaultPaymentMethod(
        Team $team,
        string $paymentMethodId,
    ): void {
        $team->createOrGetStripeCustomer();
        $team->updateDefaultPaymentMethod($paymentMethodId);
        $team->updateDefaultPaymentMethodFromStripe();
    }

    private function subscribeToPlan(
        Team $team,
        int $planId,
        string $currency,
        string $paymentMethodId,
    ): void {
        $plan = $this->planGetter->get(PlanId::from($planId));

        $team->createOrGetStripeCustomer();

        $team
            ->newSubscription(
                $plan->productStripeId,
                $currency === 'eur' ?
                    $plan->eurMonthlyPriceStripeId :
                    $plan->monthlyPriceStripeId
            )
            ->create(
                $paymentMethodId,
            );
    }
}
