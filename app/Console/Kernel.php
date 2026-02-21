<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $time = config('items.scheduler_time', '08:00');
        $schedule->command('items:check-expirations')->dailyAt($time);

        $schedule->command('reports:daily')->dailyAt('12:00');
        $schedule->command('reports:weekly')->weeklyOn(4, '0:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
