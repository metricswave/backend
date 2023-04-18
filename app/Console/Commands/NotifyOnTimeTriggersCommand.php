<?php

namespace App\Console\Commands;

use App\Jobs\QueueOnTimeTriggerNotifications;
use App\Transfers\Time;
use App\Transfers\Weekday;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

class NotifyOnTimeTriggersCommand extends Command
{
    protected $signature = 'app:trigger:on-time';
    protected $description = 'Queue on time triggers notifications';

    public function handle(): int
    {
        $this->info('Triggering on time notifications');

        QueueOnTimeTriggerNotifications::dispatch(
            Time::fromString(Date::now()->format('H:i')),
            Weekday::fromDayOfWeek(Date::now()->dayOfWeek)
        );

        return static::SUCCESS;
    }
}
