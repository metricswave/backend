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
        $schedule->command('app:mail:lead-beta-access --free-users --count=1')
            ->emailOutputTo('victoor89@gmail.com')
            ->dailyAt(8);
        $schedule->command('app:mail:lead-beta-access')->everyMinute();
        $schedule->command('app:mail:user-lifetime-licence-mail')->twiceDaily(12, 20);
        $schedule->command('app:mail-users-without-triggers-command')->twiceDaily(12, 20);

        // Triggers
        $schedule->command('app:trigger:time-to-leave')->everyMinute();
        $schedule->command('app:trigger:weather-summary')->everyMinute();
        $schedule->command('app:trigger:on-time')->everyMinute();

        // Calendar
        $schedule->command('app:user:get-calendars')->dailyAt('02:00');
        $schedule->command('app:trigger:calendar-time-to-leave')->hourly();

        // Telegram Bot
        $schedule->command('telegram:reply-with-group-id')->everyMinute();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
