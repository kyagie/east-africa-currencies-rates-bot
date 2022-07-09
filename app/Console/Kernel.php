<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Stringable;
use Spatie\SlackAlerts\Facades\SlackAlert;


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
        $schedule->call('App\Http\Controllers\RateController@index')->dailyAt('10:50')->onFailure(function (Stringable $output) {
            SlackAlert::message("*At Kernel: Error getting rates* " . $output);
        });

        $schedule->call('App\Http\Controllers\TwitterController@postRates')->dailyAt('11:05')->onFailure(function (Stringable $output) {
            SlackAlert::message("*At Kernel: Error posting rates* " . $output);
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return 'Africa/Kampala';
    }
}
