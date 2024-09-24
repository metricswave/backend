<?php

namespace App\Listeners;

use App\Services\Leads\FirstOrCreateLeadService;
use Cache;
use Laravel\Cashier\Events\WebhookReceived;
use MetricsWave\Plan\Listeners\SubscribeTeamToPlanOnIntentSucceeded;

class StripeEventListener
{
    public function __construct(
        private readonly FirstOrCreateLeadService $firstOrCreateLeadService,
        private readonly SubscribeTeamToPlanOnIntentSucceeded $intentSucceeded,
    ) {}

    public function handle(WebhookReceived $event): void
    {
        if (Cache::has($event->payload['id'])) {
            return;
        }

        Cache::put($event->payload['id'], $event->payload, now()->addMinutes(5));

        if ($event->payload['type'] === 'setup_intent.succeeded') {
            $teamId = (int) $event->payload['data']['object']['metadata']['team_id'];
            $planId = (int) $event->payload['data']['object']['metadata']['plan_id'];
            $currency = (string) $event->payload['data']['object']['metadata']['currency'];
            $paymentMethodId = (string) $event->payload['data']['object']['payment_method'];

            $this->intentSucceeded->handle($teamId, $planId, $currency, $paymentMethodId);

            return;
        }
    }
}
