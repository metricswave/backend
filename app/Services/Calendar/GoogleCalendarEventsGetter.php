<?php

namespace App\Services\Calendar;

use App\Models\User;
use App\Transfers\ServiceId;
use Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Carbon;

class GoogleCalendarEventsGetter implements EventsGetter
{
    public const SERVICE = ServiceId::Google;

    public function find(User $user, string $calendarId, string $eventId): Event
    {
        $event = Http::withHeaders(['Authorization' => 'Bearer '.$user->serviceToken(self::SERVICE)])
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

    public function incoming(User $user, string $calendarId, bool $tryToRefresh = true): Events
    {
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer '.$user->serviceToken(self::SERVICE)])
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

            return $this->events($response['items']);
        } catch (RequestException $e) {
            if ($e->response->status() === 404) {
                Http::get(
                    'https://notifywave.com/webhooks/842e2f48-4c9f-436f-bb88-c00266496f10',
                    [
                        'message' => "Google Calendar Not Found: {$calendarId} (User ID: {$user->id})",
                        'description' => $e->response->json(),
                    ]
                );

                return new Events([]);
            }

            if ($e->response->status() === 401) {
                Http::get(
                    'https://notifywave.com/webhooks/842e2f48-4c9f-436f-bb88-c00266496f10',
                    [
                        'message' => "Google Oauth Token expired (User ID: {$user->id})",
                        'description' => $e->response->json('error.message'),
                    ]
                );

                if ($tryToRefresh) {
                    $this->refreshToken($user);
                    return $this->incoming($user, $calendarId, false);
                }
            }

            throw $e;
        }
    }

    private function events(array $events): Events
    {
        $events = collect($events)->map(fn(array $event) => $this->event($event));

        return new Events($events->all());
    }

    public function refreshToken(User $user): void
    {
        $refreshToken = $user->serviceRefreshToken(self::SERVICE);

        $response = Http::post(
            'https://oauth2.googleapis.com/token',
            [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'refresh_token' => $refreshToken,
                'grant_type' => 'refresh_token',
            ]
        )
            ->throw()
            ->json();

        $user->serviceById(self::SERVICE)->update([
            'token' => $response['access_token'],
        ]);
    }
}
