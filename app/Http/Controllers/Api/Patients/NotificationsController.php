<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Booking;
use App\EventsNotification;
use App\Http\Controllers\Controller;
use App\ProviderNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class NotificationsController extends Controller
{
    public function getNotifications($id)
    {
        $events = new EventsNotification();
        $data = $events->getPatientNotifications($id);

        return response([
            'name' => 'notifications',
            'details' => $data,
        ]);
    }

    public function notifications()
    {
        EventsNotification::get();
    }

    public function notificationDetails($id)
    {
        EventsNotification::where('id', $id)->update([
            'is_read' => 1,
        ]);
        $details = DB::table('events_notification')
            ->select('events_notification.id as notification_id', 'events_notification.title', DB::raw('DATE_FORMAT(events_notification.created_at, "%m/%d/%Y %h:%i %p") as created_at'), 'events_notification.message', 'events_notification.clinic_name_1 as clinic_name', 'events_notification.appointement_date_1 as date_booked', 'events_notification.display_type', 'events_notification.status', 'events_notification.is_rated', 'events_notification.booking_id', 'events_notification.survey_link')
            ->where('events_notification.id', $id)
            ->get();

        return response([
            'name' => 'getNotificationDetails',
            'details' => $details,
        ]);
    }

    public function filter(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        if ($obj['filter'][0] === 'Events') {
            $details = DB::table('events_notification')
                ->select('id', 'title', 'display_type as type', 'is_read')
                ->where('display_type', 'Events')
                ->get();
        } elseif ($obj['filter'][0] === 'Notifications') {
            $details = DB::table('events_notification')
                ->select('id', 'title', 'display_type as type', 'is_read')
                ->where('schedule', null)
                ->where('patient_id', $id)
                ->where('display_type', 'Notifications')
                ->get();
        } elseif ($obj['filter'][0] === 'Announcements') {
            $details = DB::table('events_notification')
                ->select('id', 'title', 'display_type as type', 'is_read')
                ->where('display_type', 'Announcements')
                ->get();
        } else {
            $events = DB::table('events_notification')
                ->select('id', 'title', 'display_type as type', 'is_read')
                ->where('display_type', 'Events')
                ->where('display_type', 'Announcements');

            $notifications = DB::table('events_notification')
                ->select('id', 'title', 'display_type as type', 'is_read')
                ->where('patient_id', $id)
                ->where('display_type', 'Notifications');

            $details = $events->union($notifications)->get();
        }
        return response([
            'name' => 'notifications',
            'details' => $details,
        ]);
    }

    public function pushNotification($id)
    {
        $getClinicId = DB::table('booking')->select('clinic_id')->where('id', $id)->pluck('clinic_id');
        $getStaffId = DB::table('staffs')->select('user_id')->where('clinic_id', $getClinicId[0])->pluck('user_id');
        $getFCMToken = DB::table('users')->select('fcm_notification_key')->where('id', $getStaffId[0])->pluck('fcm_notification_key');
        $fcmurl = 'https://fcm.googleapis.com/fcm/send';
        $token = $getFCMToken[0];
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
            'Authorization: key='.env('BP_FIREBASE_SERVER_KEY').'',
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

    public function postReschedule(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        Booking::where('id', $id)->update([
            'status' => 3,
            'cancellation_message_1' => $obj['cancellation_message'],
        ]);
        $getPatientId = DB::table('booking')->select('patient_id')->where('id', $id)->pluck('patient_id');
        $getClinicId = DB::table('booking')->select('clinic_id')->where('id', $id)->pluck('clinic_id');
        $getTime = DB::table('booking')->select('time_slot')->where('id', $id)->pluck('time_slot');
        $getClinicName = DB::table('clinics')->select('clinic_name')->where('id', $getClinicId[0])->pluck('clinic_name');
        $getClinicEmail = DB::table('clinics')->select('email')->where('id', $getClinicId[0])->pluck('email');
        $message = 'You had cancelled your appointment at '.$getClinicName[0].' dated '.$getTime[0].'';
        $getPatientName = DB::table('users')->select('name')->where('id', $getPatientId[0])->pluck('name');
        EventsNotification::create([
            'patient_id' => $getPatientId[0],
            'message' => $message,
            'display_type' => 'Notifications',
            'title' => 'Booking Cancelled',
            'status' => 3,
        ]);
        Mail::send('email.patient.cancellation-booking', ['name' => $getPatientName[0], 'date' => $getTime[0]], function ($mail) use ($getClinicEmail) {
            $mail->from('notifications@friendlycare.com');
            $mail->to($getClinicEmail[0], 'Provider')->subject('Cancelled Appointment');
        });
        ProviderNotifications::create([
            'title' => 'Patient Cancelled Appointment',
            'message' => 'Your patient '.$getPatientName[0].' has been cancelled his appointment.',
            'clinic_id' => $getClinicId[0],
            'type' => 'Notifications',
            'booking_id' => $id,
            'status' => 3,
        ]);

        $this->pushNotification($id);

        return response([
            'name' => 'PostPatientReshcedule',
            'message' => 'Booking has been cancelled',
        ]);
    }
}
