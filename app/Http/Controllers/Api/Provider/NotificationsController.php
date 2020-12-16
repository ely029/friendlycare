<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Provider;

use Akaunting\Firewall\Provider;
use App\Http\Controllers\Controller;
use App\ProviderNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function getNotifications($id)
    {
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $details = DB::table('provider_notifications')
            ->select('title', 'type', 'status')
            ->where('clinic_id', $getClinicId[0])
            ->get();

        return response([
            'name' => 'ProviderNotifications',
            'details' => $details,
        ]);
    }

    public function getDetails($id)
    {
        $details = DB::table('provider_notifications')
            ->select('title', 'message', 'created_at', 'type')
            ->where('id', $id)
            ->get();

        return response([
            'name' => 'getProviderNotificationDetails',
            'details' => $details,
        ]);
    }

    public function getUpcomingBookingDetails($id)
    {
        $details = DB::table('provider_notifications')
            ->select('title', 'message', 'created_at', 'type')
            ->where('id', $id)
            ->get();

        return response([
            'name' => 'getProviderNotificationDetails',
            'details' => $details,
        ]);
    }

    public function getAllProviderNotification()
    {
        return ProviderNotifications::all();
    }
}
