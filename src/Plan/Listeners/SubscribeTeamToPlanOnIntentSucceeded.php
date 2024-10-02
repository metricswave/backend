<?php

namespace MetricsWave\Plan\Listeners;

use App\Models\User;
use App\Services\Plans\PlanGetter;
use App\Transfers\PlanId;
use Laravel\Cashier\Cashier;
use MetricsWave\Teams\Team;
use Stripe\PaymentMethod as StripePaymentMethod;

class SubscribeTeamToPlanOnIntentSucceeded
{
    public function __construct(
        private readonly PlanGetter $planGetter,
    ) {}

    public function handle(
        int $teamId,
        int $planId,
        string $currency,
        string $paymentMethodId,
    ): void {
        $team = Team::findOrFail($teamId);

        $team->update(['currency' => $currency]);

        $stripePaymentMethod = Cashier::stripe()->paymentMethods->retrieve($paymentMethodId);

        $this->changeTeamOwner($stripePaymentMethod, $team);

        $this->subscribeToPlan($team, $planId, $currency, $paymentMethodId);
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
                [
                    [
                        'price_data' => [
                            'product' => $plan->productStripeId,
                            'currency' => $currency,
                            'recurring' => ['interval' => 'month'],
                            'unit_amount' => $plan->monthlyPrice,
                        ],
                    ],
                ]
            )
            ->create(
                $paymentMethodId,
            );
    }

    private function changeTeamOwner(
        StripePaymentMethod $paymentMethod,
        Team $team
    ): void {
        $email = $paymentMethod->billing_details->email;
        $name = $paymentMethod->billing_details->name;

        $user = $this->getOrCreateUser($email, $name);

        if ($team->owner_id === $user->id) {
            return;
        }

        $previousOwner = User::find($team->owner_id);

        $team->owner_id = $user->id;

        if (! $team->users->contains($previousOwner)) {
            $team->users()->attach($previousOwner);
        }

        $team->save();
    }

    private function getOrCreateUser(mixed $email, mixed $name): User
    {
        return User::firstOrCreate(['email' => $email], [
            'name' => $name,
        ]);
    }
}
