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
        // $schedule->command('app:teams:mail-without-events --sub-days=1')->twiceDaily(10, 18);

        // Fake ecommerce
        // $schedule->command('app:fake:ecommerce-visits')->everyFiveMinutes();
        // $schedule->command('app:fake:ecommerce-funnel')->everyFiveMinutes();

        // Telegram Bot
        $schedule->command('telegram:reply-with-group-id')->everyMinute();
    }

    protected function commands(): void
    {
        $this->load([__DIR__.'/Commands']);

        require base_path('routes/console.php');
    }
}
