<?php

namespace App\Jobs\Calendar;

use App\Models\UserCalendar;
use App\Models\UserService;
use App\Services\Calendar\CalendarGetter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * @method static void dispatch($userService)
 * @method static void dispatchSync($userService)
 */
class UserServiceCalendarGetterJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly UserService $userService)
    {
    }

    public function handle(CalendarGetter $calendarGetter): void
    {
        $calendars = $calendarGetter->all($this->userService->user);

        foreach ($calendars->items() as $calendar) {
            UserCalendar::updateOrCreate(
                [
                    'user_id' => $this->userService->user->id,
                    'service_id' => $this->userService->service_id,
                    'calendar_id' => $calendar->id,
                ],
                [
                    'name' => $calendar->name,
                    'description' => $calendar->description,
                    'background_color' => $calendar->backgroundColor,
                    'foreground_color' => $calendar->foregroundColor,
                    'time_zone' => $calendar->timeZone,
                ]
            );
        }

        UserCalendar::where('user_id', $this->userService->user->id)
            ->where('service_id', $this->userService->service_id)
            ->whereNotIn('calendar_id', $calendars->items()->pluck('id'))
            ->delete();
    }
}
