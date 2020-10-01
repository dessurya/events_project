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
        'App\Console\Commands\GenerateNumberPeriodeRecord',
        'App\Console\Commands\EventOtherUpStatusCommand',
        'App\Console\Commands\EventCouponUpStatusCommand',
        'App\Console\Commands\EventTournamentToUpStatusCommand',
        'App\Console\Commands\EventCouponGenerateNewCoupon',
        'App\Console\Commands\EventTournamantToLeaderboardRankCommand'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('EventOther:status_update')->dailyAt('0:03');
        $schedule->command('EventCoupon:status_update')->dailyAt('0:15');
        $schedule->command('tourneTo:status_update')->dailyAt('0:10');
        $schedule->command('tourneTo:leaderboard_rank')->cron('0 */3 * * *'); // every 3 hour
        $schedule->command('EventCoupon:GenerateNewCoupon')->cron('0 */3 * * *'); // every 3 hour

        $schedule->command('generatenumber:record')->cron('*/10 * * * *'); // every 10 minutes
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
