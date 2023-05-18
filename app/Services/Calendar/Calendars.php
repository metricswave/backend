<?php

namespace App\Services\Calendar;

use Illuminate\Support\Collection;

class Calendars
{
    /**
     * @var Collection<Calendar> $calendars
     */
    private Collection $calendars;

    /**
     * @param  array<Calendar>  $calendars
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
