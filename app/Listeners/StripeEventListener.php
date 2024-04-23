<?php

namespace App\Listeners;

use App\Models\Lead;
use App\Models\Price;
use App\Services\Leads\FirstOrCreateLeadService;
use Laravel\Cashier\Events\WebhookReceived;
use MetricsWave\Plan\Listeners\SubscribeTeamToPlanOnIntentSucceeded;

class StripeEventListener
{
    public function __construct(
        private readonly FirstOrCreateLeadService $firstOrCreateLeadService,
        private readonly SubscribeTeamToPlanOnIntentSucceeded $intentSucceeded,
    ) {
    }

    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'checkout.session.completed') {
            $leadUuid = $event->payload['data']['object']['metadata']['lead_uuid'];
            $priceId = $event->payload['data']['object']['metadata']['price_id'];
            $createLead = $event->payload['data']['object']['metadata']['create_lead'];

            $price = Price::find($priceId);

            if ($createLead === 'true') {
                $email = $event->payload['data']['object']['customer_details']['email'];

                $lead = ($this->firstOrCreateLeadService)($email);
            } else {
                $lead = Lead::where('uuid', $leadUuid)->first();
            }

            $lead->update([
                'price_id' => $price->id,
                'paid_price' => $price->price,
                'paid_at' => now(),
            ]);

            $price->update([
                'remaining' => max(0, $price->remaining - 1),
            ]);
        }

        if ($event->payload['type'] === 'setup_intent.succeeded') {
            $teamId = (int) $event->payload['data']['object']['metadata']['team_id'];
            $planId = (int) $event->payload['data']['object']['metadata']['plan_id'];
            $currency = (string) $event->payload['data']['object']['metadata']['currency'];
            $paymentMethodId = (string) $event->payload['data']['object']['payment_method'];

            $this->intentSucceeded->handle($teamId, $planId, $currency, $paymentMethodId);
        }
    }
}
