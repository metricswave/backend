<?php

namespace App\Services\Calendar;

use App\Models\User;
use Http;
use Illuminate\Http\Client\RequestException;
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
            $event['status'] === 'confirmed',
        );
    }

    public function incoming(User $user, string $calendarId): Events
    {
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer '.$user->serviceToken('google')])
                ->get(
                    "https://www.googleapis.com/calendar/v3/calendars/{$calendarId}/events",
                    [
                        'timeMin' => now()->subMinutes(5)->toRfc3339String(),
                        'maxResults' => 50,
                        'orderBy' => 'startTime',
                        'singleEvents' => "true",
                    ]
                )
                ->throw()
                ->json();
        } catch (RequestException $e) {
            if ($e->response->status() === 404) {
                Http::post(
                    'https://notifywave.com/webhooks/842e2f48-4c9f-436f-bb88-c00266496f10',
                    [
                        'message' => "Google Calendar Not Found: {$calendarId} (User ID: {$user->id})",
                        'description' => $e->response->json(),
                    ]
                );

                return new Events([]);
            }
        }

        return $this->events($response['items']);
    }

    private function events(array $events): Events
    {
        $events = collect($events)->map(fn(array $event) => $this->event($event));

        return new Events($events->all());
    }
}
