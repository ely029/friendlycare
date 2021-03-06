<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Booking;
use App\Classes\PushNotifications;
use App\EventsNotification;
use App\Http\Controllers\Controller;
use App\ProviderNotifications;
use Carbon\Carbon;
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
        return EventsNotification::get();
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

    public function postCancellation(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        $pushNotifications = new PushNotifications();
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
            'clinic_name_1' => $getClinicName[0],
            'appointement_date_1' => $getTime[0],
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
        $pushNotifications->patientStaffPushNotification($getClinicId[0], 'Your Patient Cancelled Appointment', 'Your patient had cancelled his/her appointment at dated '.$getTime[0].'');
        $pushNotifications->providerPushNotifications('Your appointment are cancelled', 'Your appointment at '.$getClinicName[0].' are cancelled', $getPatientId[0]);

        return response([
            'name' => 'PostPatientCancelled',
            'message' => 'Booking has been cancelled',
        ]);
    }

    public function index($id)
    {
        $getBoolean = DB::table('events_notification')->select('events_display')->where('date_string', '<>', null)->orderBy('id', 'desc')->pluck('events_display');
        if ($getBoolean[0] === '0') {
            EventsNotification::where('events_display', 0)->update([
                'events_display' => '1',
            ]);
            return $this->pushNotification1($id);
        }
        return 0;
    }

    public function scheduledEvents($id)
    {
        $getBoolean1 = DB::table('events_notification')->select('events_display')->orderBy('id', 'desc')->pluck('events_display');
        if ($getBoolean1[0] === 0) {
            EventsNotification::where('events_display', 0)->update([
                'events_display' => '1',
            ]);
            return $this->pushNotification1($id);
        }
        return 0;
    }

    public function bookingTommorow($id)
    {
        $checkDisplay = DB::table('booking')->select('id')->where('book_tommorow_display', 0)->where('status', 1)->where('patient_id', $id)->count();
        $getDate = DB::table('booking')->select('time_slot')->where('book_tommorow_display', 0)->limit(1)->orderBy('id', 'desc')->where('patient_id', $id)->pluck('time_slot');
        $checkDate = Carbon::parse(date('Y-m-d'))->diffInDays($getDate[0] ?? '0000-00-00');
        $pushNotifications = new PushNotifications();

        if ($checkDate === 1 && $checkDisplay >= 1) {
            $pushNotifications->providerPushNotifications('Book Scheduled Tommorow', 'You have a Booking Scheduled Tommorow', $id);
            Booking::where('patient_id', $id)->update([
                'book_tommorow_display' => 1,
            ]);
        }
    }

    public function providerBookingTommorow($id)
    {
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $checkDisplay = DB::table('booking')->select('id')->where('book_tommorow_display', 0)->where('status', 1)->where('clinic_id', $getClinicId[0])->count();
        $getDate = DB::table('booking')->select('time_slot')->where('book_tommorow_display', 0)->limit(1)->orderBy('id', 'desc')->where('clinic_id', $getClinicId[0])->pluck('time_slot');
        $checkDate = Carbon::parse(date('Y-m-d'))->diffInDays($getDate[0] ?? '0000-00-00');
        $pushNotifications = new PushNotifications();

        if ($checkDate === 1 && $checkDisplay >= 1) {
            $pushNotifications->patientStaffPushNotification($getClinicId[0], 'Book Scheduled Tommorow', 'You have a Booking Scheduled Tommorow');
            Booking::where('clinic_id', $getClinicId[0])->update([
                'book_tommorow_display' => 1,
            ]);
        }
    }

    private function pushNotification1($id)
    {
        $user = DB::table('users')->select('fcm_notification_key')->where('id', $id)->pluck('fcm_notification_key');
        $fcmurl = 'https://fcm.googleapis.com/fcm/send';
        $token = $user[0] ?? null;
        $notification = [
            'title' => 'Events Posted',
            'body' => 'There is a Events Posted',
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
            'Authorization: key='.\Config::get('boilerplate.firebase.server_key').'',
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
}
