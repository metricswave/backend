<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Price;
use Illuminate\Http\RedirectResponse;
use Laravel\Cashier\Checkout;

class GetCheckoutController extends Controller
{
    public function __invoke(Lead $lead, Price $price): RedirectResponse
    {
        $checkout = Checkout::guest()
            ->create(
                [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'unit_amount' => $price->price,
                            'product_data' => [
                                'name' => 'Lifetime license',
                                'description' => 'Lifetime license to ' . config('app.name'),
                            ],
                        ],
                        'quantity' => 1,
                    ],
                ],
                [
                    'success_url' => url('/leads/' . $lead->uuid . '/?success=true'),
                    'cancel_url' => url('/leads/' . $lead->uuid . '?cancelled=true'),
                    'mode' => 'payment',
                    'metadata' => [
                        'lead_uuid' => $lead->uuid,
                        'price_id' => $price->id,
                    ],
                ],
            );

        return $checkout->redirect();
    }
}
