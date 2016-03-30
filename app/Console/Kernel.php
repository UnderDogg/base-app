<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CheckComputers::class,
        Commands\ActiveDirectory\SyncRole::class,
        Commands\ActiveDirectory\SyncUsers::class,
        Commands\ActiveDirectory\SyncComputers::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Scan computers every five minutes.
        $schedule->command('computers:check')->everyMinute();

        // Synchronize LDAP users.
        $schedule->command('users:sync')->hourly();

        // Synchronize LDAP computers.
        $schedule->command('computers:sync')->hourly();

        // Schedule database backup daily.
        $schedule->command('backup:run')->daily();
    }
}
