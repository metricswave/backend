<?php

namespace App\Services\Calendar;

use App\Models\User;

interface EventsGetter
{
    public function incoming(User $user, string $calendarId): Events;
}
