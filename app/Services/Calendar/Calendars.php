<?php

namespace App\Services\Calendar;

use Illuminate\Support\Collection;

class Calendars
{
    /**
     * @var Collection<CalendarTransfer> $calendars
     */
    private Collection $calendars;

    /**
     * @param  array<CalendarTransfer>  $calendars
     */
    public function __construct(
        array $calendars,
    ) {
        $this->calendars = collect($calendars);
    }

    /**
     * @return Collection<Calendars>
     */
    public function items(): Collection
    {
        return $this->calendars;
    }
}
