<?php

namespace MetricsWave\Teams\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use MetricsWave\Teams\Listeners\CreateStripeCustomerOnTeamCreated;
use MetricsWave\Teams\Listeners\SendInvitationMailOnTeamInviteCreated;
use MetricsWave\Teams\TeamCreated;
use MetricsWave\Teams\TeamInviteCreated;

class TeamServiceProvider extends EventServiceProvider
{
    protected $listen = [
        TeamInviteCreated::class => [
            SendInvitationMailOnTeamInviteCreated::class,
        ],

        TeamCreated::class => [
            CreateStripeCustomerOnTeamCreated::class,
        ],
    ];
}
