<?php

namespace App\Http\Controllers\Checkout;

use App\Models\Lead;
use App\Models\Price;
use App\Transfers\Plan;
use App\Transfers\PriceType;
use Laravel\Cashier\Checkout;
use MetricsWave\Teams\Team;
use Str;

trait HasCheckoutSessions
{
    public function authCheckout(Price $price): Checkout
    {
        $redirectTo = config('app.web_app_url').'/settings/billing?fromBillingPortal=true';
        $successPage = $redirectTo.'&success=true';
        $cancelPage = $redirectTo.'&cancelled=true';
        $data = [
            'customer_email' => $this->user()->email,
        ];

        return $this->createCheckoutSession($price, $data, $successPage, $cancelPage, null);
    }

    private function createCheckoutSession(
        Price $price,
        array $data,
        string $successPage,
        string $cancelPage,
        ?Lead $lead
    ): Checkout {
        while ($price->isAvailable() === false) {
            $price = Price::find($price->id + 1);
        }

        $interval = [];
        $mode = 'payment';
        $productData = [
            'name' => 'Lifetime license',
            'description' => 'Lifetime license to '.config('app.name'),
        ];

        if ($price->type === PriceType::Monthly) {
            $mode = 'subscription';
            $interval = [
                'recurring' => [
                    'interval' => 'month',
                ],
            ];
            $productData = [
                'name' => 'StartUp Plan',
                'description' => 'Monthly subscription to '.config('app.name'),
            ];
        }

        return Checkout::guest()
            ->create(
                [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'unit_amount' => $price->price,
                            'product_data' => $productData,
                            ...$interval,
                        ],
                        'quantity' => 1,
                    ],
                ],
                [
                    ...$data,
                    'success_url' => url($successPage),
                    'cancel_url' => url($cancelPage),
                    'mode' => $mode,
                    'metadata' => [
                        'lead_uuid' => $lead?->uuid,
                        'create_lead' => $lead === null,
                        'price_id' => $price->id,
                    ],
                ],
            );
    }

    public function authCheckoutStripeProduct(Team $team, Plan $plan, string $period): Checkout
    {
        $redirectTo = Str::of(config('app.web_app_url'))->trim('/').'/settings/billing?fromBillingPortal=true';
        $successPage = $redirectTo.'&success=true';
        $cancelPage = $redirectTo.'&cancelled=true';

        return $team
            ->newSubscription($plan->productStripeId, [
                [
                    'price_data' => [
                        'currency' => $team->preferredCurrency(),
                        'product_data' => [
                            'name' => $plan->name,
                        ],
                        'unit_amount' => $period === 'monthly' ? $plan->monthlyPrice : $plan->yearlyPrice,
                        'recurring' => [
                            'interval' => $period === 'monthly' ? 'month' : 'year',
                        ],
                    ],
                    'quantity' => 1,
                ],
            ])->checkout([
                'metadata' => [
                    'team_id' => $team->id,
                    'currency' => $team->preferredCurrency(),
                    'plan_name' => $plan->name,
                    'plan_id' => $plan->id->value,
                ],
                'success_url' => url($successPage),
                'cancel_url' => url($cancelPage),
            ]);
    }

    public function checkout(Price $price, Lead $lead = null): Checkout
    {
        if ($lead !== null) {
            $successPage = '/leads/'.$lead->uuid.'/?success=true';
            $cancelPage = '/leads/'.$lead->uuid.'?cancelled=true';
            $data = [
                'customer_email' => $lead->email,
            ];
        } else {
            $successPage = '/payment/success';
            $cancelPage = '/open';
            $data = [];
        }

        return $this->createCheckoutSession($price, $data, $successPage, $cancelPage, $lead);
    }
}
