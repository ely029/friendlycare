<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Controllers\Api\Provider\NotificationsController;
use Illuminate\Console\Command;

class SendUpcomingBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'send:booking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending Upcoming Booking email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $notification = new NotificationsController();
        $notification->upcomingBookingEmailNotif();
        return 0;
    }
}
