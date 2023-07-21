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
        $schedule->command('app:users:mail-without-events --sub-days=1')->twiceDaily(10, 18);

        // Telegram Bot
        $schedule->command('telegram:reply-with-group-id')->everyMinute();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
