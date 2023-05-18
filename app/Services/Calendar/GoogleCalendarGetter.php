<?php

namespace App\Services\Calendar;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class GoogleCalendarGetter implements CalendarGetter
{
    public function all(User $user): Calendars
    {
        $response = Http::withHeaders(['Authorization' => 'Bearer '.$user->serviceToken('google')])
            ->get(
                'https://www.googleapis.com/calendar/v3/users/me/calendarList'
            )
            ->throw()
            ->json();

        return $this->calendars($response['items']);
    }

    /**
     * @param  array{
     *     id: string,
     *     summary: string,
     *     summaryOverride: string,
     *     description: string,
     *     backgroundColor: string,
     *     foregroundColor: string,
     * }  $items
     * @return Calendars
     */
    private function calendars(array $items): Calendars
    {
        $calendars = collect($items)
            ->map(fn(array $item) => new Calendar(
                $item['id'],
                $item['summaryOverride'] ?? $item['summary'],
                $item['description'] ?? null,
                $item['foregroundColor'] ?? null,
                $item['backgroundColor'] ?? null,
                $item['timeZone'],
            ));

        return new Calendars($calendars->toArray());
    }
}
