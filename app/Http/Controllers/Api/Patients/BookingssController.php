<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Booking;
use App\BookingTime;
use App\EventsNotification;
use App\Http\Controllers\Controller;
use App\ProviderNotifications;
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
        $message = $getClinicName[0];
        EventsNotification::create([
            'patient_id' => $getPatientId[0],
            'message' => '',
            'clinic_name_1' => $message,
            'display_type' => 'Notifications',
            'title' => 'Booking Accepted',
            'appointement_date_1' => $getDate[0],
            'booking_id' => $id,
        ]);

        ProviderNotifications::create([
            'patient_id' => $getPatientId[0],
            'title' => 'Upcoming Booking Tommorow',
            'type' => 'Notifications',
            'message' => null,
            'status' => 7,
            'booking_id' => $id,
            'clinic_id' => $getClinicId[0],
            'date_booked' => $getBookedDate[0],
        ]);

        $parameter = 1;
        $this->pushNotification($parameter, $getPatientId[0]);

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
        $getPatientDate = DB::table('booking')->select('time_slot')->where('id', $id)->pluck('time_slot');
        $getClinicId = DB::table('booking')->select('clinic_id')->where('id', $id)->pluck('clinic_id');
        $getClinicName = DB::table('clinics')->select('clinic_name')->where('id', $getClinicId[0])->pluck('clinic_name');
        $getPatientName = DB::table('users')->select('name')->where('id', $getPatientId[0])->pluck('name');
        $message = $getClinicName[0];
        EventsNotification::create([
            'patient_id' => $getPatientId[0],
            'message' => '',
            'clinic_name_1' => $message,
            'appointement_date_1' => $getPatientDate[0],
            'display_type' => 'Notifications',
            'title' => 'Booking Cancelled',
            'status' => 3,
        ]);

        ProviderNotifications::create([
            'title' => 'Patient cancelled',
            'message' => 'Your patient '.$getPatientName[0].' has been cancelled',
            'clinic_id' => $getClinicId[0],
            'type' => 'Notifications',
            'booking_id' => $id,
            'status' => 2,
        ]);
        $parameter = 3;
        $this->pushNotification1($parameter, $getPatientId[0]);
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

        $parameter = 2;
        $this->pushNotification($parameter, $getPatientId[0]);

        return response([
            'name' => 'postProviderReschedule',
            'message' => 'Reschedule is successful',
        ]);
    }

    public function pushNotification($parameter, $id)
    {
        if ($parameter === 1) {
            $user = DB::table('users')->select('fcm_notification_key')->where('id', $id)->pluck('fcm_notification_key');
            $fcmurl = 'https://fcm.googleapis.com/fcm/send';
            $token = $user[0];
            $notification = [
                'title' => 'Booking Confirmed',
                'body' => 'Your Booking is confirmed',
                'icon' => 'myIcon',
                'sound' => 'defaultSound',
                'priority' => 'high',
                'contentAvailable' => true,
            ];

            $extraNotifications = ['message' => $notification, 'moredata' => 'bb'];

            $fcmNotification = [
                'to' => $token,
                'notification' => $notification,
                'data' => $extraNotifications,
            ];

            $headers = [
                'Authorization: key=AAAAhGKDgoo:APA91bGxHrVfvIgku3NIcP7P3EerjE1cE_zHRXp9dVOp8RYkhb3o1Cv5g26R5Lx8vXFZoBCM10-YsSCfyBkxy34ORiqK_hLJjrJcAxnIUOswhJrgxHoOtmTgUca0gXkb4kx_ZkyAEa84',
                'Content-Type: application/json',
            ];
            $chh = curl_init();
            curl_setopt($chh, CURLOPT_URL, $fcmurl);
            curl_setopt($chh, CURLOPT_POST, true);
            curl_setopt($chh, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($chh, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chh, CURLOPT_SSL_VERIFYPEER, $headers);
            curl_setopt($chh, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($chh);
            curl_close($chh);

            return $result;
        }
        if ($parameter === 2) {
            $user = DB::table('users')->select('fcm_notification_key')->where('id', $id)->pluck('fcm_notification_key');
            $fcmurl = 'https://fcm.googleapis.com/fcm/send';
            $token = $user[0];
            $notification = [
                'title' => 'Booking Rescheduled',
                'body' => 'Your Booking is Rescheduled',
                'icon' => 'myIcon',
                'sound' => 'defaultSound',
                'priority' => 'high',
                'contentAvailable' => true,
            ];

            $extraNotifications = ['message' => $notification, 'moredata' => 'bb'];

            $fcmNotification = [
                'to' => $token,
                'notification' => $notification,
                'data' => $extraNotifications,
            ];

            $headers = [
                'Authorization: key=AAAAhGKDgoo:APA91bGxHrVfvIgku3NIcP7P3EerjE1cE_zHRXp9dVOp8RYkhb3o1Cv5g26R5Lx8vXFZoBCM10-YsSCfyBkxy34ORiqK_hLJjrJcAxnIUOswhJrgxHoOtmTgUca0gXkb4kx_ZkyAEa84',
                'Content-Type: application/json',
            ];
            $chh = curl_init();
            curl_setopt($chh, CURLOPT_URL, $fcmurl);
            curl_setopt($chh, CURLOPT_POST, true);
            curl_setopt($chh, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($chh, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chh, CURLOPT_SSL_VERIFYPEER, $headers);
            curl_setopt($chh, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($chh);
            curl_close($chh);

            return $result;
        }
        return true;
    }

    public function pushNotification1($parameter, $id)
    {
        if ($parameter === 3) {
            $user = DB::table('users')->select('fcm_notification_key')->where('id', $id)->pluck('fcm_notification_key');
            $fcmurl = 'https://fcm.googleapis.com/fcm/send';
            $token = $user[0];
            $notification = [
                'title' => 'Booking Cancelled',
                'body' => 'Your Booking is Cancelled',
                'icon' => 'myIcon',
                'sound' => 'defaultSound',
                'priority' => 'high',
                'contentAvailable' => true,
            ];

            $extraNotifications = ['message' => $notification, 'moredata' => 'bb'];

            $fcmNotification = [
                'to' => $token,
                'notification' => $notification,
                'data' => $extraNotifications,
            ];

            $headers = [
                'Authorization: key=AAAAhGKDgoo:APA91bGxHrVfvIgku3NIcP7P3EerjE1cE_zHRXp9dVOp8RYkhb3o1Cv5g26R5Lx8vXFZoBCM10-YsSCfyBkxy34ORiqK_hLJjrJcAxnIUOswhJrgxHoOtmTgUca0gXkb4kx_ZkyAEa84',
                'Content-Type: application/json',
            ];
            $chh = curl_init();
            curl_setopt($chh, CURLOPT_URL, $fcmurl);
            curl_setopt($chh, CURLOPT_POST, true);
            curl_setopt($chh, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($chh, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chh, CURLOPT_SSL_VERIFYPEER, $headers);
            curl_setopt($chh, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($chh);
            curl_close($chh);

            return $result;
        }
        return true;
    }
}
