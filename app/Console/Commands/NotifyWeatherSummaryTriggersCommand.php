<?php

namespace App\Console\Commands;

use App\Jobs\QueueWeatherSummaryTriggerNotificationsJob;
use App\Transfers\Time;
use App\Transfers\Weekday;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

class NotifyWeatherSummaryTriggersCommand extends Command
{
    protected $signature = 'app:trigger:weather-summary';
    protected $description = 'Queue weather summary triggers notifications.';

    public function handle(): int
    {
        $this->info('Triggering weather summary notifications');

        $time = Time::fromString(Date::now()->format('H:i'));
        $weekday = Weekday::fromDayOfWeek(Date::now()->dayOfWeek);

        QueueWeatherSummaryTriggerNotificationsJob::dispatch($time, $weekday);

        $this->info("Done (Time: {$time->toString()}, Weekday: {$weekday->toString()})");

        return static::SUCCESS;
    }
}
