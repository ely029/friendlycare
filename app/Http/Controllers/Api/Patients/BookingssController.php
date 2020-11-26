<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Booking;
use App\BookingTime;
use App\EventsNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingssController extends Controller
{
    public function approveBooking(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        $startTime = date('Y-m-d H:i');
        $endtime = date('Y-m-d H:i', strtotime('3 minutes', strtotime($startTime)));
        DB::update('update booking set status = ? where id = ?', [1, $id]);
        DB::update('update booking_time set status = ? where time_slot = ? and booking_id = ?', [1, $obj['time_slot'][0], $id]);
        BookingTime::where(['booking_id' => $id, 'status' => null])->delete();
        $getBookedDate = DB::table('booking')->select('time_slot')->where('id', $id)->first();
        $getBookedTime = DB::table('booking_time')->select('time_slot')->where('booking_id', $id)->first();
        $bookedTime = date('H:i:s', strtotime($getBookedTime->time_slot));
        $starttime = strtotime($getBookedDate->time_slot.''.$bookedTime);
        $endtime = date('Y-m-d H:i', strtotime('3 minutes', $starttime));
        DB::update('update booking set end_time = ? where id = ?', [strtotime($endtime), $id]);
        $data = Booking::where('id', $id)->get();

        $getPatientId = DB::table('booking')->select('patient_id')->where('id', $id)->pluck('patient_id');
        $getDate = DB::table('booking')->select('time_slot')->where('id', $id)->pluck('time_slot');
        $getClinicId = DB::table('booking')->select('clinic_id')->where('id', $id)->pluck('clinic_id');
        $getClinicName = DB::table('clinics')->select('clinic_name')->where('id', $getClinicId[0])->pluck('clinic_name');
        $message = 'Your booking for '.$getDate[0].' has been confirmed at '.$getClinicName[0].'';

        EventsNotification::create([
            'patient_id' => $getPatientId[0],
            'message' => $message,
            'display_type' => 'Notifications',
            'title' => 'Booking Accepted',
        ]);

        return response([
            'name' => 'BookApproved',
            'message' => 'Book Approved!',
            'data' => $data,
            'title' => 'Booking Accepted',
        ]);
    }
}
