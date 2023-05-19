<?php

namespace App\Services\Calendar;

use App\Models\User;
use Http;
use Illuminate\Support\Carbon;

class GoogleCalendarEventsGetter implements EventsGetter
{
    public function find(User $user, string $calendarId, string $eventId): Event
    {
        $event = Http::withHeaders(['Authorization' => 'Bearer '.$user->serviceToken('google')])
            ->get("https://www.googleapis.com/calendar/v3/calendars/{$calendarId}/events/{$eventId}")
            ->throw()
            ->json();

        return $this->event($event);
    }

    private function event(array $event): Event
    {
        return new Event(
            $event['id'],
            $event['summary'],
            $event['location'] ?? null,
            isset($event['start']['dateTime']) ?
                Carbon::parse($event['start']['dateTime']) :
                Carbon::parse($event['start']['date']),
            !isset($event['start']['dateTime']),
        );
    }

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

    private function events(array $events): Events
    {
        $events = collect($events)->map(fn(array $event) => $this->event($event));

        return new Events($events->all());
    }
}
