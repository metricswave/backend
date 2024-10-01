<?php

namespace MetricsWave\Teams\Listeners;

use MetricsWave\Teams\TeamCreated;

class CreateStripeCustomerOnTeamCreated
{
    public function handle(TeamCreated $event): void
    {
        if (! app()->environment('production')) {
            return;
        }

        $team = $event->team;
        $team->createOrGetStripeCustomer();
    }
}
