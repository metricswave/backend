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
        $schedule->command('app:teams:mail-without-events --sub-days=1')->twiceDaily(10, 18);

        // Create next year vistis table
        $schedule->command('visits:create-table --execute')->yearlyOn(12, 1, '06:00')
            ->emailOutputTo('victoor89@gmail.com');

        // Create next year notifications table
        $schedule->command('users:create-notifications-table --execute')->yearlyOn(12, 1, '05:00')
            ->emailOutputTo('victoor89@gmail.com');

        // Telegram Bot
        $schedule->command('telegram:reply-with-group-id')->everyTwoSeconds();
    }

    protected function commands(): void
    {
        $this->load([__DIR__.'/Commands']);

        require base_path('routes/console.php');
    }
}
