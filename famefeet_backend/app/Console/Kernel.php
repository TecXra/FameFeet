<?php

namespace App\Console;

use App\Models\Celebrity;
use App\Models\SubcribeUser;
use App\Models\Subcription;
use App\Models\Wallet;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('auto:pakistan')->everyMinute();

        // $schedule->command('inspire')->hourly();
        $schedule->command('auto:subscribe')->everyMinute();
        $schedule->command('change:referralstatus')->everyMinute();
        $schedule->command('auto:complete_order')->everyMinute();
//        $schedule->command('warning:mail')->daily();
//        $schedule->command('warning:mail_auto_subscribe')->daily();
        $schedule->command('order:cancel_auto')->everyTwoMinutes();

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
