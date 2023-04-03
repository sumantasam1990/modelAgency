<?php

namespace App\Console;

use App\Console\Commands\GetWinners;
use App\Console\Commands\WinnersSendEmail;
use App\Jobs\SendWinnersEmailsJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        WinnersSendEmail::class,
        GetWinners::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('command:sendemailtowinners')->everyMinute();
        $schedule->command('save:winners')->daily()->runInBackground();
        $schedule->command('monthly:subscription')->twiceDaily()->runInBackground();

//        $schedule->command('report:generate')
//            ->everyMinute()
//            ->emailOutputTo('sumantasam1990@gmail.com');
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
