<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\EventsNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function getNotifications($id)
    {
        $events = DB::table('events_notification')
            ->select('id', 'title', 'display_type as type', 'is_read')
            ->where('date_string', '>=', strtotime(date('Y-m-d')))
            ->where('display_type', 'Announcements')
            ->orWhere('display_type', 'Events');

        $notifications = DB::table('events_notification')
            ->select('id', 'title', 'display_type as type', 'is_read')
            ->where('patient_id', $id)
            ->where('display_type', 'Notifications');

        $data = $events->union($notifications)->get();

        return response([
            'name' => 'notifications',
            'details' => $data,
        ]);
    }

    public function notificationDetails($id)
    {
        EventsNotification::where('id', $id)->update([
            'is_read' => 1,
        ]);
        $details = DB::table('events_notification')

            ->select('events_notification.id as notification_id', 'events_notification.title', DB::raw('DATE_FORMAT(events_notification.created_at, "%m/%d/%Y %h:%i %p") as created_at'), 'events_notification.message', 'events_notification.clinic_name_1 as clinic_name', 'events_notification.appointement_date_1 as date_booked', 'events_notification.display_type', 'events_notification.status', 'events_notification.is_rated', 'events_notification.booking_id')
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
                ->orWhere('display_type', 'Announcements');

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

    public function pushNotification(Request $request)
    {
        $obj = json_decode($request->getContent(), true);
        $fcmurl = 'https://fcm.googleapis.com/fcm/send';
        $token = $obj['token'][0];

        $notification = [
            'title' => 'sample title',
            'body' => 'sample body from laravel',
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

        return response([
            'response' => $result,
        ]);
    }
}
