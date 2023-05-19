<?php

namespace App\Listeners;

use App\Events\UserServiceCreated;
use App\Jobs\Calendar\UserServiceCalendarGetterJob;
use App\Transfers\ServiceId;

class GetCalendarsOnGoogleUserServiceCreated
{
    public function handle(UserServiceCreated $event): void
    {
        if ($event->userService->service_id !== ServiceId::Google->value) {
            return;
        }

        UserServiceCalendarGetterJob::dispatch($event->userService);
    }
}
