<?php

declare(strict_types=1);

namespace App\Classes;

use App\Booking;
use Illuminate\Support\Facades\DB;

class GetCancelledStatus
{
    public function index($request)
    {
        $booking = new Booking();
        if ($request['clinic_id'] === null && $request['service_id'] === null) {
            return $booking->getCancelledCountFirstScenario($request);
        }

        if ($request['clinic_id'] !== null && $request['service_id'] === null) {
            return $booking->getCancelledCountSecondScenario($request);
        }

        if ($request['clinic_id'] === null && $request['service_id'] !== null) {
            return $booking->getCancelledCountThirdScenario($request);
        }
        return DB::table('booking')
            ->select('id')
            ->where('status', 3)
            ->where('clinic_id', $request['clinic_id'])
            ->where('service_id', $request['service_id'])
            ->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])
            ->count();
    }
}
