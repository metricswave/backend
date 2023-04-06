<?php

namespace App\Listeners;

use App\Models\Lead;
use App\Models\Price;
use App\Services\Leads\FirstOrCreateLeadService;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    public function __construct(private readonly FirstOrCreateLeadService $firstOrCreateLeadService)
    {
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
                $lead->update(['paid_price' => $price->price, 'paid_at' => now()]);
            } else {
                Lead::where('uuid', $leadUuid)
                    ->update(['paid_price' => $price->price, 'paid_at' => now()]);
            }

            $price->update([
                'remaining' => max(0, $price->remaining - 1),
            ]);
        }
    }
}
