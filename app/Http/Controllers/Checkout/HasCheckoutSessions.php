<?php

namespace App\Http\Controllers\Checkout;

use App\Models\Lead;
use App\Models\Price;
use Laravel\Cashier\Checkout;

trait HasCheckoutSessions
{
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

        while ($price->isAvailable() === false) {
            $price = Price::find($price->id + 1);
        }

        return Checkout::guest()
            ->create(
                [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'unit_amount' => $price->price,
                            'product_data' => [
                                'name' => 'Lifetime license',
                                'description' => 'Lifetime license to '.config('app.name'),
                            ],
                        ],
                        'quantity' => 1,
                    ],
                ],
                [
                    ...$data,
                    'success_url' => url($successPage),
                    'cancel_url' => url($cancelPage),
                    'mode' => 'payment',
                    'metadata' => [
                        'lead_uuid' => $lead?->uuid,
                        'create_lead' => $lead === null,
                        'price_id' => $price->id,
                    ],
                ],
            );
    }
}
