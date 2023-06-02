<?php

namespace App\Console;

use App\Console\Commands\DeleteOldActiveCaptchas;
use App\Console\Commands\UpdateKey;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(DeleteOldActiveCaptchas::class)->everyMinute();
        $schedule->command(UpdateKey::class)->everyMinute();

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
