<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function getInBoxDetails($id)
    {
        $bookings = new Booking();
        $details = $bookings->getInBoxDetails($id);

        return response([
            'name' => 'getInboxDetails',
            'details' => $details,
        ]);
    }

    public function getInboxPerBooking($id)
    {
        Booking::where('id', $id)->update([
            'is_read_patient_booking' => 0,
        ]);
        $bookings = new Booking();
        $details = $bookings->getInboxPerBooking($id);

        return response([
            'name' => 'getInboxDetailsPerBooking',
            'details' => $details,
        ]);
    }

    public function filterPerStatus(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        $bookings = new Booking();
        $details = $bookings->filterPerStatus($id, $obj);

        return response([
            'name' => 'filterPerStatus',
            'details' => $details,
        ]);
    }
}
