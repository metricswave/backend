<?php

namespace Tests\Feature\Services\Calendar;

use Illuminate\Support\Facades\Http;

class GoogleCalendarList
{
    public static function fake(): void
    {
        Http::fake([
            'https://www.googleapis.com/calendar/v3/users/me/calendarList' => Http::response(
                \Safe\json_decode('{
    "etag": "\"p33c979lbmfvfs0g\"",
    "items": [
        {
            "accessRole": "owner",
            "backgroundColor": "#42d0f4",
            "colorId": "16",
            "conferenceProperties": {
                "allowedConferenceSolutionTypes": [
                    "hangoutsMeet"
                ]
            },
            "defaultReminders": [
                {
                    "method": "popup",
                    "minutes": 4
                },
                {
                    "method": "popup",
                    "minutes": 45
                }
            ],
            "etag": "\"1668611578600000\"",
            "foregroundColor": "#000000",
            "id": "q1a2alu219e1tofg74k4p87vuk@group.calendar.google.com",
            "kind": "calendar#calendarListEntry",
            "selected": true,
            "summary": "Deporte",
            "timeZone": "Europe/Madrid"
        },
        {
            "accessRole": "owner",
            "backgroundColor": "#4986e7",
            "colorId": "16",
            "conferenceProperties": {
                "allowedConferenceSolutionTypes": [
                    "hangoutsMeet"
                ]
            },
            "defaultReminders": [
                {
                    "method": "popup",
                    "minutes": 45
                }
            ],
            "etag": "\"1668680862953000\"",
            "foregroundColor": "#000000",
            "id": "victoor89@gmail.com",
            "kind": "calendar#calendarListEntry",
            "notificationSettings": {
                "notifications": [
                    {
                        "method": "email",
                        "type": "eventCreation"
                    },
                    {
                        "method": "email",
                        "type": "eventChange"
                    },
                    {
                        "method": "email",
                        "type": "eventCancellation"
                    },
                    {
                        "method": "email",
                        "type": "eventResponse"
                    }
                ]
            },
            "primary": true,
            "selected": true,
            "summary": "Personal",
            "timeZone": "Europe/Madrid"
        },
        {
            "accessRole": "owner",
            "backgroundColor": "#92e1c0",
            "colorId": "13",
            "conferenceProperties": {
                "allowedConferenceSolutionTypes": [
                    "hangoutsMeet"
                ]
            },
            "defaultReminders": [],
            "etag": "\"1668680864215000\"",
            "foregroundColor": "#000000",
            "id": "q7ojfsflp18bfo1hgregtk254o@group.calendar.google.com",
            "kind": "calendar#calendarListEntry",
            "selected": true,
            "summary": "Vacaciones",
            "timeZone": "Europe/Madrid"
        },
        {
            "accessRole": "reader",
            "backgroundColor": "#985df6",
            "colorId": "23",
            "conferenceProperties": {
                "allowedConferenceSolutionTypes": [
                    "hangoutsMeet"
                ]
            },
            "defaultReminders": [],
            "description": "Matches of the national team",
            "etag": "\"1669195214190000\"",
            "foregroundColor": "#ffffff",
            "id": "8n8ctvj3uu2ltaq1objjdtn41g@group.calendar.google.com",
            "kind": "calendar#calendarListEntry",
            "selected": true,
            "summary": "⚽️ Spain",
            "timeZone": "UTC"
        },
        {
            "accessRole": "reader",
            "backgroundColor": "#b99aff",
            "colorId": "18",
            "conferenceProperties": {
                "allowedConferenceSolutionTypes": [
                    "hangoutsMeet"
                ]
            },
            "defaultReminders": [
                {
                    "method": "popup",
                    "minutes": 10
                }
            ],
            "description": "Alle wedstrijden van Real Madrid",
            "etag": "\"1669195235801000\"",
            "foregroundColor": "#000000",
            "id": "dptm8psv9fk6khmphttvmrapp4@group.calendar.google.com",
            "kind": "calendar#calendarListEntry",
            "selected": true,
            "summary": "Real Madrid",
            "summaryOverride": "⚽ Real Madrid",
            "timeZone": "UTC"
        },
        {
            "accessRole": "reader",
            "backgroundColor": "#b99aff",
            "colorId": "18",
            "conferenceProperties": {
                "allowedConferenceSolutionTypes": [
                    "hangoutsMeet"
                ]
            },
            "defaultReminders": [
                {
                    "method": "popup",
                    "minutes": 10
                }
            ],
            "description": "Alle wedstrijden van FC Barcelona",
            "etag": "\"1669195239559000\"",
            "foregroundColor": "#000000",
            "id": "lhp7tvdd3b467f6a6hdcbea9ag@group.calendar.google.com",
            "kind": "calendar#calendarListEntry",
            "selected": true,
            "summary": "FC Barcelona",
            "summaryOverride": "⚽ FC Barcelona",
            "timeZone": "UTC"
        },
        {
            "accessRole": "reader",
            "backgroundColor": "#b99aff",
            "colorId": "18",
            "conferenceProperties": {
                "allowedConferenceSolutionTypes": [
                    "hangoutsMeet"
                ]
            },
            "defaultReminders": [
                {
                    "method": "popup",
                    "minutes": 10
                }
            ],
            "description": "Alle wedstrijden van Atlético Madrid",
            "etag": "\"1677140113118000\"",
            "foregroundColor": "#000000",
            "id": "jehhenv8d959cob5e6n68g3f1k@group.calendar.google.com",
            "kind": "calendar#calendarListEntry",
            "selected": true,
            "summary": "Atlético Madrid",
            "summaryOverride": "⚽ Atlético Madrid",
            "timeZone": "UTC"
        },
        {
            "accessRole": "reader",
            "backgroundColor": "#16a765",
            "colorId": "8",
            "conferenceProperties": {
                "allowedConferenceSolutionTypes": [
                    "hangoutsMeet"
                ]
            },
            "defaultReminders": [],
            "description": "Holidays and Observances in Spain",
            "etag": "\"1677140133905000\"",
            "foregroundColor": "#000000",
            "id": "en.spain#holiday@group.v.calendar.google.com",
            "kind": "calendar#calendarListEntry",
            "selected": true,
            "summary": "Holidays in Spain",
            "summaryOverride": "🏖️ Holidays in Spain",
            "timeZone": "Europe/Madrid"
        }
    ],
    "kind": "calendar#calendarList",
    "nextSyncToken": "CNiTpquz_v4CEhN2aWN0b29yODlAZ21haWwuY29t"
}', true)
            ),
        ]);
    }
}
