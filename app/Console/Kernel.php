<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Horizon
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        // Mails
        $schedule->command('app:mail:user-lifetime-licence-mail')->twiceDaily(12, 20);

        // Triggers
        $schedule->command('app:trigger:on-time')->everyMinute()
            ->appendOutputTo(storage_path('logs/trigger-on-time.log'));
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
