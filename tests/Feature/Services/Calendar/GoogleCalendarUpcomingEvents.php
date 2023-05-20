<?php

namespace Tests\Feature\Services\Calendar;

use Illuminate\Support\Facades\Http;

class GoogleCalendarUpcomingEvents
{
    public function fakeWith(array $events): void
    {
        Http::fake([
            'https://www.googleapis.com/calendar/v3/calendars/valid-cal-id/events*' => Http::response([
                'items' => $events,
            ]),
        ]);
    }

    public static function fake(): void
    {
        Http::fake([
            'https://www.googleapis.com/calendar/v3/calendars/valid-cal-id/events*' => Http::response([
                'accessRole' => 'owner',
                'defaultReminders' => [
                    0 => [
                        'method' => 'popup',
                        'minutes' => 45,
                    ],
                ],
                'etag' => '"p33c979lbmfvfs0g"',
                'items' => [
                    0 => [
                        'created' => '2023-05-12T15:07:57.000Z',
                        'creator' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'end' => [
                            'dateTime' => '2023-05-19T12:30:00+02:00',
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'etag' => '"3367808154250000"',
                        'eventType' => 'default',
                        'htmlLink' => 'https://www.google.com/calendar/event?eid=XzYxMWsyZTltODRxNDZiYTQ4NHNrNmI5azg4b2s4YjlvNm9yM2FiOWk4ZDE0YWdpNTY4czMyZGhnODQgdmljdG9vcjg5QG0',
                        'iCalUID' => '0CA96A4C-DA9C-4B1D-8665-2CBEBE28160A',
                        'id' => '_611k2e9m84q46ba484sk6b9k88ok8b9o6or3ab9i8d14agi568s32dhg84',
                        'kind' => 'calendar#event',
                        'location' => 'Euroindoor Alcorcón',
                        'organizer' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'reminders' => [
                            'useDefault' => true,
                        ],
                        'sequence' => 0,
                        'start' => [
                            'dateTime' => now()->setTime(12, 30)->toRfc3339String(),
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'status' => 'confirmed',
                        'summary' => 'Padel ',
                        'updated' => '2023-05-12T15:07:57.125Z',
                    ],
                    1 => [
                        'attendees' => [
                            0 => [
                                'email' => 'victoor89@gmail.com',
                                'organizer' => true,
                                'responseStatus' => 'accepted',
                                'self' => true,
                            ],
                            1 => [
                                'displayName' => 'Raquel',
                                'email' => 'raquelcalvo_1@hotmail.com',
                                'responseStatus' => 'needsAction',
                            ],
                        ],
                        'created' => '2023-05-16T16:52:02.000Z',
                        'creator' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'end' => [
                            'dateTime' => '2023-05-20T22:00:00+02:00',
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'etag' => '"3368511897850000"',
                        'eventType' => 'default',
                        'guestsCanModify' => true,
                        'htmlLink' => 'https://www.google.com/calendar/event?eid=ZWIyNzg0YWE0ZThhNDZhZjhiODUwNmJhYmQ1Yjc5NjAgdmljdG9vcjg5QG0',
                        'iCalUID' => 'eb2784aa4e8a46af8b8506babd5b7960@google.com',
                        'id' => 'eb2784aa4e8a46af8b8506babd5b7960',
                        'kind' => 'calendar#event',
                        'location' => 'C. de la Reina, 27, 28004 Madrid, Spain',
                        'organizer' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'reminders' => [
                            'useDefault' => true,
                        ],
                        'sequence' => 0,
                        'start' => [
                            'dateTime' => now()->addDay()->setTime(12, 30)->toRfc3339String(),
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'status' => 'confirmed',
                        'summary' => '🇰🇷 Korean BBQ <> Raquel',
                        'updated' => '2023-05-16T16:52:28.925Z',
                    ],
                    2 => [
                        'created' => '2023-04-20T19:02:01.000Z',
                        'creator' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'end' => [
                            'dateTime' => '2023-05-23T21:00:00+02:00',
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'etag' => '"3365721548768000"',
                        'eventType' => 'default',
                        'guestsCanModify' => true,
                        'htmlLink' => 'https://www.google.com/calendar/event?eid=YzlhZDVjODYxNjFlNDI2YTlhNDY1YjBmMWFlODM4MzNfMjAyMzA1MjNUMTgwMDAwWiB2aWN0b29yODlAbQ',
                        'iCalUID' => 'c9ad5c86161e426a9a465b0f1ae83833@google.com',
                        'id' => 'c9ad5c86161e426a9a465b0f1ae83833_20230523T180000Z',
                        'kind' => 'calendar#event',
                        'location' => 'Euroindoor Alcorcón S.L, C. los Pintores, 7, 28923 Madrid, Spain',
                        'organizer' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'originalStartTime' => [
                            'dateTime' => '2023-05-23T20:00:00+02:00',
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'recurringEventId' => 'c9ad5c86161e426a9a465b0f1ae83833',
                        'reminders' => [
                            'useDefault' => true,
                        ],
                        'sequence' => 1,
                        'start' => [
                            'dateTime' => now()->addDays(3)->setTime(12, 30)->toRfc3339String(),
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'status' => 'confirmed',
                        'summary' => '🎾 Padel Lesson (C. 15 - David)',
                        'updated' => '2023-04-30T13:19:34.384Z',
                    ],
                    3 => [
                        'created' => '2023-05-17T11:02:53.000Z',
                        'creator' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'end' => [
                            'dateTime' => '2023-05-24T12:30:00+02:00',
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'etag' => '"3368642747556000"',
                        'eventType' => 'default',
                        'htmlLink' => 'https://www.google.com/calendar/event?eid=XzZvb2plZDIzNnAyM2NiOXA2cDIzNmI5azZ0MWs2YjlwNjkxazRiOW44b3MzYWRwcDYwcWphZDlrNzAgdmljdG9vcjg5QG0',
                        'iCalUID' => '6174C6D6-96D3-47CC-92CB-7F8579055548',
                        'id' => '_6oojed236p23cb9p6p236b9k6t1k6b9p691k4b9n8os3adpp60qjad9k70',
                        'kind' => 'calendar#event',
                        'location' => 'Euroindoor Alcorcón',
                        'organizer' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'reminders' => [
                            'useDefault' => true,
                        ],
                        'sequence' => 0,
                        'start' => [
                            'dateTime' => now()->addDays(3)->setTime(17, 30)->toRfc3339String(),
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'status' => 'confirmed',
                        'summary' => 'Padel ',
                        'updated' => '2023-05-17T11:02:53.778Z',
                    ],
                    4 => [
                        'attendees' => [
                            0 => [
                                'email' => 'victoor89@gmail.com',
                                'responseStatus' => 'accepted',
                                'self' => true,
                            ],
                            1 => [
                                'email' => 'victoria@clicars.com',
                                'responseStatus' => 'needsAction',
                            ],
                            2 => [
                                'email' => 'atipa@clicars.com',
                                'organizer' => true,
                                'responseStatus' => 'accepted',
                            ],
                            3 => [
                                'email' => 'ivan@clicars.com',
                                'responseStatus' => 'accepted',
                            ],
                            4 => [
                                'email' => 'alvaro@clicars.com',
                                'responseStatus' => 'needsAction',
                            ],
                        ],
                        'created' => '2023-05-17T15:52:26.000Z',
                        'creator' => [
                            'email' => 'atipa@clicars.com',
                        ],
                        'description' => '<u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><span><span><span><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u>Hola </span></span></span>Víctor <br><u></u><span><span><span><br>La prueba de selección de la segunda fase consiste en resolver un problema donde deberás desarrollar una buena solución orientada a objetos, utilizando las estructuras de datos necesarias y con algoritmos eficientes.<br><br>Aunque en Clicars utilizamos diferentes lenguajes y tecnologías, el utilizado para la prueba será PHP, puesto que es el que usamos en más proyectos. Utilizamos PHP 8, 100% tipado. Solo necesitas tener montado un entorno donde ejecutar php-cli, y sería recomendable utilizar un IDE para facilitar el desarrollo.<br><br>El enunciado de la prueba está en inglés y tiene un tiempo máximo de 3 horas de duración, si la resuelves en menos de 2 horas tienes bonus. </span></span></span><u></u><br><u></u><span><span><span>Recibirás un comprimido con las interfaces de donde partir y algunos tests para probar tu solución.<br><br>Mucha suerte !<br><br>Un abrazo,<p><b>Adrian</b><b> Tipa</b></p><p><b>Senior IT &amp; Digital </b><b>Talent Acquisition </b></p><p>+34 631270331</p><p><a href="https://www.google.com/maps/place/Clicars">Av. Laboral, 10 - 28021 Madrid</a></p><p>Le informamos que, de conformidad con lo establecido en el Reglamento (UE) 2016/679, de 27 de abril de 2016, de tratamiento de datos personales (GDPR), y la Ley Orgánica 3/2018, de 5 de diciembre, de Protección de Datos Personales y garantía de los derechos digitales, los datos personales que figuran es esta comunicación podrán ser tratados por parte de Clicars Spain, S.L., cuya finalidad será la de gestionar la actividad de la compañía. Si desea ejercitar los derechos de acceso, rectificación, supresión (cancelación), oposición, portabilidad, olvido y limitación del tratamiento, o si desea oponerse a nuestro uso de su información personal, por favor escríbanos a <a href="mailto:legal@clicars.com">legal@clicars.com</a> o Av. Laboral, núm. 10, 28021 – Madrid. Podrá acceder a la política de privacidad accediendo a nuestra página web: <a href="http://www.clicars.com/">www.clicars.com</a>. Este mensaje y, en su caso, los ficheros anexos, son confidenciales, especialmente en lo que respecta a los datos personales, y se dirigen exclusivamente al destinatario referenciado. Si usted no lo es y lo ha recibido por error o tiene conocimiento del mismo por cualquier motivo, le rogamos que nos lo comunique por este medio y proceda a destruirlo o borrarlo, y que en todo caso se abstenga de utilizar, reproducir, alterar, archivar o comunicar a terceros el presente mensaje y ficheros anexos, todo ello bajo pena de incurrir en responsabilidades legales. </p><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u></span></span></span><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u><u></u>',
                        'end' => [
                            'dateTime' => '2023-05-24T19:00:00+02:00',
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'etag' => '"3368793750574000"',
                        'eventType' => 'default',
                        'htmlLink' => 'https://www.google.com/calendar/event?eid=NWV2a3VnYzVnNWp0bGcxdHZybjByMWthOTMgdmljdG9vcjg5QG0',
                        'iCalUID' => '5evkugc5g5jtlg1tvrn0r1ka93@google.com',
                        'id' => '5evkugc5g5jtlg1tvrn0r1ka93',
                        'kind' => 'calendar#event',
                        'organizer' => [
                            'email' => 'atipa@clicars.com',
                        ],
                        'reminders' => [
                            'useDefault' => true,
                        ],
                        'sequence' => 0,
                        'start' => [
                            'dateTime' => now()->addDays(4)->setTime(12, 30)->toRfc3339String(),
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'status' => 'confirmed',
                        'summary' => 'Prueba Técnica Software Engineer Clicars // Víctor Falcón Ruíz',
                        'updated' => '2023-05-18T08:01:15.287Z',
                    ],
                    5 => [
                        'created' => '2023-05-17T15:52:05.000Z',
                        'creator' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'end' => [
                            'dateTime' => '2023-05-24T19:00:00+02:00',
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'etag' => '"3368677451212000"',
                        'eventType' => 'default',
                        'guestsCanModify' => true,
                        'htmlLink' => 'https://www.google.com/calendar/event?eid=OGQ3NTA5NGVjYWI4NDI4NzllNGJiOTgwZGU1ZjY1OTcgdmljdG9vcjg5QG0',
                        'iCalUID' => '8d75094ecab842879e4bb980de5f6597@google.com',
                        'id' => '8d75094ecab842879e4bb980de5f6597',
                        'kind' => 'calendar#event',
                        'organizer' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'reminders' => [
                            'useDefault' => true,
                        ],
                        'sequence' => 0,
                        'start' => [
                            'dateTime' => now()->addDays(5)->setTime(12, 30)->toRfc3339String(),
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'status' => 'confirmed',
                        'summary' => '🚕 CliCars <> Prueba Técnica',
                        'updated' => '2023-05-17T15:52:05.606Z',
                    ],
                    6 => [
                        'created' => '2023-04-20T19:02:01.000Z',
                        'creator' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'end' => [
                            'dateTime' => '2023-05-30T21:00:00+02:00',
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'etag' => '"3365721548768000"',
                        'eventType' => 'default',
                        'guestsCanModify' => true,
                        'htmlLink' => 'https://www.google.com/calendar/event?eid=YzlhZDVjODYxNjFlNDI2YTlhNDY1YjBmMWFlODM4MzNfMjAyMzA1MzBUMTgwMDAwWiB2aWN0b29yODlAbQ',
                        'iCalUID' => 'c9ad5c86161e426a9a465b0f1ae83833@google.com',
                        'id' => 'c9ad5c86161e426a9a465b0f1ae83833_20230530T180000Z',
                        'kind' => 'calendar#event',
                        'location' => 'Euroindoor Alcorcón S.L, C. los Pintores, 7, 28923 Madrid, Spain',
                        'organizer' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'originalStartTime' => [
                            'dateTime' => '2023-05-30T20:00:00+02:00',
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'recurringEventId' => 'c9ad5c86161e426a9a465b0f1ae83833',
                        'reminders' => [
                            'useDefault' => true,
                        ],
                        'sequence' => 1,
                        'start' => [
                            'dateTime' => now()->addDays(6)->setTime(12, 30)->toRfc3339String(),
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'status' => 'confirmed',
                        'summary' => '🎾 Padel Lesson (C. 15 - David)',
                        'updated' => '2023-04-30T13:19:34.384Z',
                    ],
                    7 => [
                        'created' => '2018-06-02T18:21:51.000Z',
                        'creator' => [
                            'displayName' => 'Víctor Falcón',
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'end' => [
                            'date' => '2023-06-04',
                        ],
                        'etag' => '"3056212015638000"',
                        'eventType' => 'default',
                        'extendedProperties' => [
                            'private' => [
                                'everyoneDeclinedDismissed' => '-1',
                            ],
                        ],
                        'htmlLink' => 'https://www.google.com/calendar/event?eid=N2NlM2R2Y2E5YTJqMGVsaW40MW82MnFmbGtfMjAyMzA2MDMgdmljdG9vcjg5QG0',
                        'iCalUID' => '7ce3dvca9a2j0elin41o62qflk@google.com',
                        'id' => '7ce3dvca9a2j0elin41o62qflk_20230603',
                        'kind' => 'calendar#event',
                        'organizer' => [
                            'displayName' => 'Víctor Falcón',
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'originalStartTime' => [
                            'date' => '2023-06-03',
                        ],
                        'recurringEventId' => '7ce3dvca9a2j0elin41o62qflk',
                        'reminders' => [
                            'overrides' => [
                                0 => [
                                    'method' => 'popup',
                                    'minutes' => 900,
                                ],
                            ],
                            'useDefault' => false,
                        ],
                        'sequence' => 1,
                        'start' => [
                            'date' => now()->addDays(9)->setTime(12, 30)->toDateString(),
                        ],
                        'status' => 'confirmed',
                        'summary' => '🎂 Cumpleaños de Dani',
                        'transparency' => 'transparent',
                        'updated' => '2018-06-04T09:53:27.819Z',
                    ],
                    8 => [
                        'created' => '2023-04-20T19:02:01.000Z',
                        'creator' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'end' => [
                            'dateTime' => '2023-06-06T21:00:00+02:00',
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'etag' => '"3365721548768000"',
                        'eventType' => 'default',
                        'guestsCanModify' => true,
                        'htmlLink' => 'https://www.google.com/calendar/event?eid=YzlhZDVjODYxNjFlNDI2YTlhNDY1YjBmMWFlODM4MzNfMjAyMzA2MDZUMTgwMDAwWiB2aWN0b29yODlAbQ',
                        'iCalUID' => 'c9ad5c86161e426a9a465b0f1ae83833@google.com',
                        'id' => 'c9ad5c86161e426a9a465b0f1ae83833_20230606T180000Z',
                        'kind' => 'calendar#event',
                        'location' => 'Euroindoor Alcorcón S.L, C. los Pintores, 7, 28923 Madrid, Spain',
                        'organizer' => [
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'originalStartTime' => [
                            'dateTime' => '2023-06-06T20:00:00+02:00',
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'recurringEventId' => 'c9ad5c86161e426a9a465b0f1ae83833',
                        'reminders' => [
                            'useDefault' => true,
                        ],
                        'sequence' => 1,
                        'start' => [
                            'dateTime' => now()->addDays(9)->setTime(12, 30)->toRfc3339String(),
                            'timeZone' => 'Europe/Madrid',
                        ],
                        'status' => 'confirmed',
                        'summary' => '🎾 Padel Lesson (C. 15 - David)',
                        'updated' => '2023-04-30T13:19:34.384Z',
                    ],
                    9 => [
                        'created' => '2018-06-04T09:53:28.000Z',
                        'creator' => [
                            'displayName' => 'Víctor Falcón',
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'end' => [
                            'date' => '2023-06-13',
                        ],
                        'etag' => '"3056212016744000"',
                        'eventType' => 'default',
                        'htmlLink' => 'https://www.google.com/calendar/event?eid=Y29zbWFjcjI3NWgzZ2I5azZrb2owYjlrYzRzNjhiOXA3MWk2MmI5aDc0cGo2YzFwNzRxMzRvYjU2Y18yMDIzMDYxMiB2aWN0b29yODlAbQ',
                        'iCalUID' => 'cosmacr275h3gb9k6koj0b9kc4s68b9p71i62b9h74pj6c1p74q34ob56c@google.com',
                        'id' => 'cosmacr275h3gb9k6koj0b9kc4s68b9p71i62b9h74pj6c1p74q34ob56c_20230612',
                        'kind' => 'calendar#event',
                        'organizer' => [
                            'displayName' => 'Víctor Falcón',
                            'email' => 'victoor89@gmail.com',
                            'self' => true,
                        ],
                        'originalStartTime' => [
                            'date' => '2023-06-12',
                        ],
                        'recurringEventId' => 'cosmacr275h3gb9k6koj0b9kc4s68b9p71i62b9h74pj6c1p74q34ob56c',
                        'reminders' => [
                            'overrides' => [
                                0 => [
                                    'method' => 'popup',
                                    'minutes' => 900,
                                ],
                            ],
                            'useDefault' => false,
                        ],
                        'sequence' => 0,
                        'start' => [
                            'date' => now()->addDays(9)->setTime(12, 30)->toDateString(),
                        ],
                        'status' => 'confirmed',
                        'summary' => '🎂 Cumpleaños papá',
                        'transparency' => 'transparent',
                        'updated' => '2018-06-04T09:53:28.412Z',
                    ],
                ],
                'kind' => 'calendar#events',
                'nextPageToken' => 'Ek4KQ2Nvc21hY3IyNzVoM2diOWs2a29qMGI5a2M0czY4YjlwNzFpNjJiOWg3NHBqNmMxcDc0cTM0b2I1NmNfMjAyMzA2MTIYgIDgsra8_wIiBwgFEOv56DI=',
                'summary' => 'Personal',
                'timeZone' => 'Europe/Madrid',
                'updated' => '2023-05-18T08:01:15.287Z',
            ]),
        ]);
    }
}
