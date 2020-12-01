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
        $message = 'Your booking for '.$getDate[0].' has been confirmed at '.$getClinicName[0].'\n\n\n\n\n Check your Bookings menu to learn more details.\n\n\n\n\n Please be reminded, you can not cancel bookings within 3 days of your appointment date';

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
        ])
            ->header('Content-type', 'application/json');
    }

    public function approveCancellationDetails(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        DB::update('update booking set cancellation_message_1 = ?, status = ? where id = ?', [$obj['cancellation_message'][0], 3, $id]);
        DB::update('update booking_time set status = ? where booking_id = ?', [3, $id]);
        $getPatientId = DB::table('booking')->select('patient_id')->where('id', $id)->pluck('patient_id');
        $getClinicId = DB::table('booking')->select('clinic_id')->where('id', $id)->pluck('clinic_id');
        $getClinicName = DB::table('clinics')->select('clinic_name')->where('id', $getClinicId[0])->pluck('clinic_name');
        $message = 'Your Clinic,'.$getClinicName[0].' had cancelled your appointment';
        EventsNotification::create([
            'patient_id' => $getPatientId[0],
            'message' => $message,
            'display_type' => 'Notifications',
            'title' => 'Booking Cancelled',
        ]);
        return response([
            'name' => 'ApproveCancellation',
            'message' => 'This booking is cancelled',
        ]);
    }

    public function createReschedule(Request $request, $id)
    {
        Booking::where('id', $id)->update([
            'status' => 2,
        ]);
        BookingTime::where('booking_id', $id)->delete();
        $obj = json_decode($request->getContent(), true);
        $getPatient = DB::table('booking')
            ->select('patient_id')
            ->where('id', $id)
            ->pluck('patient_id');
        Booking::where('id', $id)->update([
            'time_slot' => $obj['date'][0],
        ]);

        for ($eee = 0; $eee <= 100; $eee++) {
            if (isset($obj['time'][$eee])) {
                BookingTime::create([
                    'patient_id' => $getPatient[0],
                    'booking_id' => $id,
                    'time_slot' => $obj['time'][$eee],
                ]);
            }
        }
        $getPatientId = DB::table('booking')->select('patient_id')->where('id', $id)->pluck('patient_id');
        $getClinicId = DB::table('booking')->select('clinic_id')->where('id', $id)->pluck('clinic_id');
        $getClinicName = DB::table('clinics')->select('clinic_name')->where('id', $getClinicId[0])->pluck('clinic_name');
        $message = 'Your Booking  at '.$getClinicName[0].' had been rescheduled at '.$obj['date'][0].', '.$obj['time'][$eee].'';
        EventsNotification::create([
            'patient_id' => $getPatientId[0],
            'message' => $message,
            'display_type' => 'Notifications',
            'title' => 'Booking Rescheduled',
        ]);

        return response([
            'name' => 'postProviderReschedule',
            'message' => 'Reschedule is successful',
        ]);
    }
}
