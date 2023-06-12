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

    public function incoming(User $user, string $calendarId): Events
    {
        try {
            $this->refreshToken($user);

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
                return new Events([]);
            }

            if ($e->response->status() === 401) {
                Http::get(
                    'https://metricswave.com/webhooks/842e2f48-4c9f-436f-bb88-c00266496f10',
                    [
                        'message' => "Google Oauth Token expired (User ID: {$user->id})",
                        'description' => $e->response->json('error.message'),
                    ]
                );

                $user->userServiceById(self::SERVICE)->update(['reconectable' => true]);
            }

            throw $e;
        }
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

        $userService = $user->userServiceById(self::SERVICE);
        $data = $userService->service_data;
        $data['token'] = $response['access_token'];
        if (isset($response['refresh_token'])) {
            $data['refreshToken'] = $response['refresh_token'];
        }

        $userService->service_data = $data;
        $userService->save();
    }

    private function events(array $events): Events
    {
        $events = collect($events)->map(fn(array $event) => $this->event($event));

        return new Events($events->all());
    }
}
