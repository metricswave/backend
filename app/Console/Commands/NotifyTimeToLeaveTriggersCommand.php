<?php

namespace App\Console\Commands;

use App\Jobs\CalculateTravelTimeAndEnqueueNotificationsOnTimeJob;
use App\Transfers\Time;
use App\Transfers\Weekday;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

class NotifyTimeToLeaveTriggersCommand extends Command
{
    private const HOURS_BEFORE = 4;
    protected $signature = 'app:trigger:time-to-leave {time?} {weekday?}';
    protected $description = 'Check time to leave triggers to queue a notification on time.';

    public function handle(): int
    {
        $this->info('Getting time to leave triggers 4 hours before arrival time');
        $date = Date::now()->addHours(self::HOURS_BEFORE);

        if ($this->argument('time')) {
            $time = Time::fromString($this->argument('time'));
        } else {
            $time = Time::fromString($date->format('H:i'));
        }

        if ($this->argument('weekday')) {
            $weekday = Weekday::fromString($this->argument('weekday'));
        } else {
            $weekday = Weekday::fromDayOfWeek($date->dayOfWeek);
        }

        CalculateTravelTimeAndEnqueueNotificationsOnTimeJob::dispatch($time, $weekday);

        $this->info("Done (Time: {$time->toString()}, Weekday: {$weekday->toString()})");

        return static::SUCCESS;
    }
}
