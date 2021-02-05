<?php

declare(strict_types=1);

namespace App\Classes;

use App\Booking;
use Illuminate\Support\Facades\DB;

class GetCompletedStatus
{
    public function index($request)
    {
        $booking = new Booking();
        if ($request['clinic_id'] === null && $request['service_id'] === null) {
            return $booking->getCompleteCountFirstScenario($request);
        }

        if ($request['clinic_id'] !== null && $request['service_id'] === null) {
            return $booking->getCompleteCountSecondScenario($request);
        }

        if ($request['clinic_id'] === null && $request['service_id'] !== null) {
            return $booking->getCompleteCountThirdScenario($request);
        }
        return DB::table('booking')
            ->select('id')
            ->where('status', 4)
            ->where('clinic_id', $request['clinic_id'])
            ->where('service_id', $request['service_id'])
            ->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])
            ->count();
    }
}
