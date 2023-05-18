<?php

namespace App\Services\Calendar;

use Illuminate\Support\Collection;

class Events
{
    /**
     * @var Collection<Event> $calendars
     */
    private Collection $events;

    /**
     * @param  array<Event>  $events
     */
    public function __construct(
        array $events,
    ) {
        $this->events = collect($events);
    }

    /**
     * @return Collection<Calendars>
     */
    public function items(): Collection
    {
        return $this->events;
    }
}
