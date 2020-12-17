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
        $providerNotifications = new ProviderNotifications();
        $providerNotifications->checkUpcomingBooking();
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $details = DB::table('provider_notifications')
            ->select('id', 'title', 'type', 'status', 'is_read')
            ->where('clinic_id', $getClinicId[0])
            ->get();

        return response([
            'name' => 'ProviderNotifications',
            'details' => $details,
        ]);
    }

    public function getDetails($id)
    {
        ProviderNotifications::where('id', $id)->update([
            'is_read' => 1,
        ]);
        $getStatusId = DB::table('provider_notifications')->select('status')->where('id', $id)->pluck('status');

        if ($getStatusId[0] === 7) {
            $getBookingId = DB::table('provider_notifications')->select('booking_id')->where('id', $id)->pluck('booking_id');
            $details = DB::table('booking')
                ->join('users', 'booking.patient_id', 'users.id')
                ->join('booking_time', 'booking_time.booking_id', 'booking.id')
                ->join('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
                ->select('booking.created_at', 'booking.patient_id', 'users.name', 'booking.time_slot as date_booked', 'booking_time.time_slot', 'family_plan_type_subcategory.name as service_name', 'users.age', 'users.birth_date', 'users.contact_number_1 as contact_number', 'booking.referal')
                ->where('booking.id', $getBookingId[0])
                ->get();
        } else {
            $details = DB::table('provider_notifications')
                ->select('title', 'message', DB::raw('DATE_FORMAT(created_at, "%m/%d/%Y %h:%i %p") as created_at'), 'type')
                ->where('id', $id)
                ->get();
        }

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
