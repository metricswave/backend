<?php

namespace App\Services\Calendar;

use App\Models\User;

interface EventsGetter
{
    public function find(User $user, string $calendarId, string $eventId): Event;

    public function incoming(User $user, string $calendarId): Events;
}
