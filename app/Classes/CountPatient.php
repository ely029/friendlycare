<?php

declare(strict_types=1);

namespace App\Classes;

use App\Booking;

class CountPatient
{
    public function index($request, $dateFrom, $dateTo)
    {
        $booking = new Booking();
        if ($request['clinic_id'] === null && $request['service_id'] === null && $request['status'] === null) {
            return $booking->countPatientFirstScenario($dateFrom, $dateTo);
        }
        if ($request['clinic_id'] === null && $request['service_id'] === null && $request['status'] !== null) {
            return $booking->countPatientSecondScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] === null && $request['service_id'] !== null && $request['status'] !== null) {
            return $booking->countPatientThirdScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] !== null && $request['service_id'] === null && $request['status'] !== null) {
            return $booking->countPatientFourthScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] !== null && $request['service_id'] !== null && $request['status'] === null) {
            return $booking->countPatientFifthScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] !== null && $request['service_id'] === null && $request['status'] === null) {
            return $booking->countPatientSeventhScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] === null && $request['service_id'] !== null && $request['status'] === null) {
            return $booking->countPatientEighthScenario($request, $dateFrom, $dateTo);
        }
    }
}
