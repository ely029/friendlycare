<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Booking;
use App\BookingTime;
use App\Classes\PushNotifications;
use App\EventsNotification;
use App\Http\Controllers\Controller;
use App\ProviderNotifications;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class BookingssController extends Controller
{
    public function approveBooking(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        $startTime = date('Y-m-d H:i');
        $pushNotifications = new PushNotifications();
        $providerNotifications = new ProviderNotifications();
        $eventsNotification = new EventsNotification();
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
        $message = $getClinicName[0];
        $eventsNotification->createNotification($getPatientId, $message, $getDate, $id);
        $providerNotifications->createNotification($getPatientId, $getClinicId, $getBookedDate, $id);
        $pushNotifications->providerPushNotifications('Booking Confirmed', 'Booking is Confirmed', $getPatientId[0]);
        $this->checkBookingTommorow($getClinicId[0]);

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
        $pushNotifications = new PushNotifications();
        $providerNotifications = new ProviderNotifications();
        $eventsNotification = new EventsNotification();
        DB::update('update booking set cancellation_message_1 = ?, status = ? where id = ?', [$obj['cancellation_message'][0], 3, $id]);
        DB::update('update booking_time set status = ? where booking_id = ?', [3, $id]);
        $getPatientId = DB::table('booking')->select('patient_id')->where('id', $id)->pluck('patient_id');
        $getPatientDate = DB::table('booking')->select('time_slot')->where('id', $id)->pluck('time_slot');
        $getClinicId = DB::table('booking')->select('clinic_id')->where('id', $id)->pluck('clinic_id');
        $getClinicName = DB::table('clinics')->select('clinic_name')->where('id', $getClinicId[0])->pluck('clinic_name');
        $getPatientName = DB::table('users')->select('name')->where('id', $getPatientId[0])->pluck('name');
        $message = $getClinicName[0];
        $eventsNotification->cancellationNotifications($getPatientId, $message, $getPatientDate);
        $providerNotifications->cancellationNotifications($getPatientName, $getClinicId, $id);
        $pushNotifications->providerPushNotifications('Booking Cancelled', 'Booking is Cancelled', $getPatientId[0]);
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
        $pushNotifications = new PushNotifications();
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
        $getClinicEmail = DB::table('clinics')->select('email')->where('id', $getClinicId[0])->pluck('email');
        $getPatientName = DB::table('users')->select('name')->where('id', $getPatientId[0])->pluck('name');
        $message = $getClinicName[0];
        EventsNotification::create([
            'patient_id' => $getPatientId[0],
            'message' => '',
            'clinic_name_1' => $message,
            'display_type' => 'Notifications',
            'title' => 'Booking Rescheduled',
            'appointement_date_1' => $obj['date'][0],
            'status' => 2,
        ]);
        ProviderNotifications::create([
            'title' => 'Rescheduled Successful',
            'message' => 'Your patient '.$getPatientName[0].' has been successfully rescheduled to '.$obj['date'][0].'',
            'clinic_id' => $getClinicId[0],
            'type' => 'Notifications',
            'booking_id' => $id,
            'status' => 2,
        ]);
        Mail::send('email.patient.provider.provider-reschedule', ['time' => $obj['date'][0], 'name' => $getPatientName[0]], function ($mail) use ($getClinicEmail) {
            $mail->from('notifications@friendlycare.com');
            $mail->to($getClinicEmail[0], 'Patient')->subject('Provider Reschedule');
        });
        $pushNotifications->patientStaffPushNotification($getClinicId[0], 'Reschedule Successful', 'Your patient '.$getPatientName[0].' has been successfully rescheduled to '.$obj['date'][0].'');
        $pushNotifications->providerPushNotifications('Booking Rescheduled', 'Booking is Rescheduled', $getPatientId[0]);

        return response([
            'name' => 'postProviderReschedule',
            'message' => 'Reschedule is successful',
        ]);
    }

    public function providerNotifications()
    {
        return ProviderNotifications::get();
    }

    private function checkBookingTommorow($id)
    {
        $checkDisplay = DB::table('booking')->select('id')->where('book_tommorow_display', 0)->where('status', 1)->where('clinic_id', $id)->count();
        $getDate = DB::table('booking')->select('time_slot')->where('book_tommorow_display', 0)->limit(1)->orderBy('id', 'desc')->where('clinic_id', $id)->pluck('time_slot');
        $checkDate = Carbon::parse(date('Y-m-d'))->diffInDays($getDate[0] ?? '0000-00-00');
        $pushNotifications = new PushNotifications();

        if ($checkDate === 1 && $checkDisplay >= 1) {
            $pushNotifications->patientStaffPushNotification($id, 'Book Scheduled Tommorow', 'You have a Booking Scheduled Tommorow');
            Booking::where('clinic_id', $id)->update([
                'book_tommorow_display' => 1,
            ]);
        }
    }
}
