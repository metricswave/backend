<?php

namespace MetricsWave\Teams\Listeners;

use Illuminate\Support\Facades\Mail;
use MetricsWave\Teams\Mail\TeamInvitedMail;
use MetricsWave\Teams\TeamInviteCreated;

class SendInvitationMailOnTeamInviteCreated
{
    public function handle(TeamInviteCreated $event): void
    {
        Mail::to($event->invite->email)->send(
            new TeamInvitedMail($event->invite),
        );
    }
}
