<?php

namespace App\Services\Calendar;

use App\Models\User;

interface CalendarGetter
{
    public function all(User $user): Calendars;
}
