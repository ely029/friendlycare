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
            ->where('date_string', '>=', strtotime(date('Y-m-d')));

        $notifications = DB::table('events_notification')
            ->select('id', 'title', 'display_type as type', 'is_read')
            ->where('schedule', null)
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
        $getPatientId = DB::table('events_notification')->select('patient_id')->where('id', $id)->pluck('patient_id');
        $details = DB::table('events_notification')
            ->join('booking', 'booking.patient_id', 'events_notification.patient_id')
            ->select('events_notification.id', 'events_notification.title', 'events_notification.created_at', 'events_notification.message', 'events_notification.display_type', 'booking.status', 'booking.id as booking_id')
            ->where('events_notification.id', $id)
            ->where('booking.patient_id', $getPatientId[0])
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
                ->where('date_string', '>=', strtotime(date('Y-m-d')))
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
                ->where('schedule', null)
                ->where('patient_id', $id)
                ->where('display_type', 'Announcements')
                ->get();
        } else {
            $events = DB::table('events_notification')
                ->select('id', 'title', 'display_type as type', 'is_read')
                ->where('date_string', '>=', strtotime(date('Y-m-d')));

            $notifications = DB::table('events_notification')
                ->select('id', 'title', 'display_type as type', 'is_read')
                ->where('schedule', null)
                ->where('patient_id', $id)
                ->where('display_type', 'Notifications');

            $details = $events->union($notifications)->get();
        }
        return response([
            'name' => 'notifications',
            'details' => $details,
        ]);
    }
}
