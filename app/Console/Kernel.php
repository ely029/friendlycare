<?php

declare(strict_types=1);

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
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // @TB: We set it to 30 days so that devs have enough data for debugging.
        // @TB: It is also enough for QA to file and verify issues.
        // https://laravel.com/docs/telescope#data-pruning
        $schedule->command('telescope:prune --hours=720')->daily();

        // @TB: See config/firewall
        $schedule->command('firewall:unblockip')->everyMinute();

        // @TB: Run the queue worker every minute if it is not already running,
        // and retry failed jobs every 30 seconds for the next 24 hours.
        // `withoutOverlapping()` expires in 24 hours by default.
        // https://medium.com/@sdkcodes/using-laravel-queues-on-shared-hosting-a-simple-guide-9f976ccf99f3
        $schedule->command('queue:work --tries=43200 --delay=30')
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping();
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
}
