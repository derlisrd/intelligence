<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        Commands\CronCampanhas::class,
        Commands\CotacaoCron::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        //
        $schedule->command('cotacao:cron')->twiceDaily(1, 13);
        $schedule->command('getcampaigns:cron')->hourly();
        //$schedule->command('getcampaigns:cron')->everyFifteenMinutes();
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
