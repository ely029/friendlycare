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
            ->select('title', 'display_type as type', 'is_read')
            ->where('date_string', '>=', strtotime(date('Y-m-d')));

        $notifications = DB::table('events_notification')
            ->select('title', 'display_type as type', 'is_read')
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
        $details = DB::table('events_notification')
            ->select('title', 'created_at', 'message', 'display_type')
            ->where('id', $id)
            ->get();

        return response([
            'name' => 'getNotificationDetails',
            'details' => $details,
        ]);
    }
}
