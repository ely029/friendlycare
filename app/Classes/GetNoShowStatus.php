<?php

declare(strict_types=1);

namespace App\Classes;

use App\Booking;
use Illuminate\Support\Facades\DB;

class GetNoShowStatus
{
    public function index($request)
    {
        $booking = new Booking();
        if ($request['clinic_id'] === null && $request['service_id'] === null) {
            return $booking->getNoShowCountFirstScenario($request);
        }

        if ($request['clinic_id'] !== null && $request['service_id'] === null) {
            return $booking->getNoShowCountSecondScenario($request);
        }

        if ($request['clinic_id'] === null && $request['service_id'] !== null) {
            return $booking->getNoShowCountThirdScenario($request);
        }

        if ($request['clinic_id'] !== null && $request['service_id'] !== null && $request['status'] === null) {
            return $booking->getNoShowCountFourthScenario($request);
        }
        return DB::table('booking')
            ->select('id')
            ->where('status', 5)
            ->where('clinic_id', $request['clinic_id'])
            ->where('service_id', $request['service_id'])
            ->where('status', $request['status'])
            ->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])
            ->count();
    }
}
