<?php

namespace App\Services\Calendar;

use App\Models\User;
use Carbon\Carbon;
use Http;

class GoogleCalendarEventsGetter implements EventsGetter
{
    public function incoming(User $user, string $calendarId): Events
    {
        $response = Http::withHeaders(['Authorization' => 'Bearer '.$user->serviceToken('google')])
            ->get(
                "https://www.googleapis.com/calendar/v3/calendars/{$calendarId}/events",
                [
                    'timeMin' => now()->subMinutes(5)->toRfc3339String(),
                    'maxResults' => 50,
                    'orderBy' => 'startTime',
                    'singleEvents' => true,
                ]
            )
            ->throw()
            ->json();

        return $this->events($response['items']);
    }

    private function events(array $items): Events
    {
        $events = collect($items)
            ->map(fn(array $item) => new Event(
                $item['id'],
                $item['summary'],
                $item['location'] ?? null,
                isset($item['start']['dateTime']) ?
                    Carbon::parse($item['start']['dateTime']) :
                    Carbon::parse($item['start']['date']),
            ));

        return new Events($events->toArray());
    }
}
