<?php

namespace App\Listeners;

use App\Models\Lead;
use App\Models\Price;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'charge.succeeded') {
            $email = $event->payload['data']['object']['billing_details']['email'];
            $amount = $event->payload['data']['object']['amount'];

            Lead::where('email', $email)
                ->update([
                    'paid_price' => $amount,
                    'paid_at' => now(),
                ]);

            $price = Price::where('price', $amount)->first();
            $price?->update([
                'remaining' => $price->remaining - 1,
            ]);
        }
    }
}
