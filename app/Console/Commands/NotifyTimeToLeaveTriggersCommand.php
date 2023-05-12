<?php

namespace App\Console\Commands;

use App\Jobs\CalculateTravelTimeAndEnqueueNotificationsOnTimeJob;
use App\Services\Triggers\TimeToLeaveTriggersProcessor;
use App\Transfers\Time;
use App\Transfers\Weekday;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

class NotifyTimeToLeaveTriggersCommand extends Command
{
    protected $signature = 'app:trigger:time-to-leave {time?} {weekday?}';
    protected $description = 'Check time to leave triggers to queue a notification on time.';

    public function handle(): int
    {
        $hoursBefore = TimeToLeaveTriggersProcessor::HOURS_BEFORE;
        $date = Date::now()->addHours($hoursBefore);

        if ($this->argument('time')) {
            $this->info('Getting time to leave triggers with arrival time '.$this->argument('time'));
        } else {
            $this->info('Getting time to leave triggers '.$hoursBefore.' hours before arrival time');
        }

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
