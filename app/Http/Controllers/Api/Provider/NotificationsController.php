<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Provider;

use App\Http\Controllers\Controller;
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
        $getStatus = DB::table('provider_notifications')->select('status')->where('id', $id)->first();

        if ($getStatus[0] === 2) {
            $details = DB::table('provider_notifications')
                ->select('title', 'message', 'created_at', 'type')
                ->where('id', $id)
                ->get();

            return response([
                'name' => 'getProviderNotificationDetails',
                'details' => $details,
            ]);
        }
    }
}
