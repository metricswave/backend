<?php

namespace Tests\Feature\Services\Calendar;

use App\Models\UserCalendar;
use App\Services\Calendar\Event;
use Illuminate\Support\Facades\Http;

class GoogleCalendarEventFind
{
    public static function fakeWith(UserCalendar $calendar, Event $event): void
    {
        Http::fake([
            "https://www.googleapis.com/calendar/v3/calendars/{$calendar->calendar_id}/events/{$event->id}" => Http::response([
                'created' => '2023-05-12T15:07:57.000Z',
                'creator' => [
                    'email' => 'victoor89@gmail.com',
                    'self' => true,
                ],
                'end' => [
                    'dateTime' => $event->startAt()->addHour()->toRfc3339String(),
                    'timeZone' => 'Europe/Madrid',
                ],
                'etag' => '"3367808154250000"',
                'eventType' => 'default',
                'htmlLink' => 'https://www.google.com/calendar/event?eid=XzYxMWsyZTltODRxNDZiYTQ4NHNrNmI5azg4b2s4YjlvNm9yM2FiOWk4ZDE0YWdpNTY4czMyZGhnODQgdmljdG9vcjg5QG0',
                'iCalUID' => '0CA96A4C-DA9C-4B1D-8665-2CBEBE28160A',
                'id' => $event->id,
                'kind' => 'calendar#event',
                'location' => $event->location,
                'organizer' => [
                    'email' => 'victoor89@gmail.com',
                    'self' => true,
                ],
                'reminders' => [
                    'useDefault' => true,
                ],
                'sequence' => 0,
                'start' => $event->isAllDay ?
                    [
                        'date' => $event->startAt()->toDateString(),
                    ] : [
                        'dateTime' => $event->startAt()->toRfc3339String(),
                        'timeZone' => 'Europe/Madrid',
                    ],
                'status' => $event->isConfirmed ? 'confirmed' : 'tentative',
                'summary' => $event->summary,
                'updated' => '2023-05-12T15:07:57.125Z',
            ]),
        ]);
    }

    public static function fakeNoFoundWith(UserCalendar $calendar, Event $event): void
    {
        Http::fake([
            "https://www.googleapis.com/calendar/v3/calendars/{$calendar->calendar_id}/events/{$event->id}" => Http::response(
                [],
                404
            ),
        ]);
    }
}
