<?php

namespace App\Listeners;

use App\Events\TriggerNotificationSent;
use App\Notifications\TriggerLimitReachedNotification;

class CheckUsageLimitOnTriggerNotificationSent
{
    public function handle(TriggerNotificationSent $event): void
    {
        $user = $event->notification->trigger->user;

        if ($user->triggerNotificationVisitsLimitReached()) {
            $user->notify(new TriggerLimitReachedNotification());
        }
    }
}
