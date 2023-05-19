<?php

namespace App\Console\Commands;

use App\Jobs\Calendar\EnqueueCalendarTimeToLeaveTriggerJob;
use Illuminate\Console\Command;

class NotifyCalendarTimeToLeaveTriggersCommand extends Command
{
    protected $signature = 'app:trigger:calendar-time-to-leave ';
    protected $description = 'Check calendar time to leave triggers to queue a notification for events on time.';

    public function handle(): int
    {
        EnqueueCalendarTimeToLeaveTriggerJob::dispatch();

        $this->info("Done");

        return static::SUCCESS;
    }
}
