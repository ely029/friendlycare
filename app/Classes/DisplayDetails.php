<?php

declare(strict_types=1);

namespace App\Classes;

use App\Booking;

class DisplayDetails
{
    public function index($request, $dateFrom, $dateTo)
    {
        $booking = new Booking();
        if ($request['clinic_id'] === null && $request['service_id'] === null && $request['status'] === null) {
            return $booking->displayCountFirstScenario($dateFrom, $dateTo);
        }
        if ($request['clinic_id'] === null && $request['service_id'] === null && $request['status'] !== null) {
            return $booking->displayCountSecondScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] === null && $request['service_id'] !== null && $request['status'] !== null) {
            return $booking->displayCountThirdScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] !== null && $request['service_id'] === null && $request['status'] !== null) {
            return $booking->displayCountFourthScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] !== null && $request['service_id'] !== null && $request['status'] === null) {
            return $booking->displayCountFifthScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] === null && $request['service_id'] !== null && $request['status'] === null) {
            return $booking->displayCountEighthScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] !== null && $request['service_id'] === null && $request['status'] === null) {
            return $booking->displayCountSeventhScenario($request, $dateFrom, $dateTo);
        }
        return $booking->displayCountNinthScenario($request, $dateFrom, $dateTo);
    }
}
