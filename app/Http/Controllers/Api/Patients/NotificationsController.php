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
        $getPatientId = DB::table('events_notification')->select('patient_id')->where('id', $id)->pluck('patient_id');
        $details = DB::table('events_notification')
            ->leftJoin('booking', 'booking.patient_id', 'events_notification.patient_id')
            ->select('events_notification.id', 'events_notification.title', 'events_notification.created_at', 'events_notification.message', 'events_notification.display_type', 'booking.status', 'booking.id as booking_id')
            ->where('events_notification.id', $id)
            ->where('booking.patient_id', $getPatientId[0])
            ->get();

        return response([
            'name' => 'getNotificationDetails',
            'details' => $details,
        ]);
    }
}
