<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Provider;

use Akaunting\Firewall\Provider;
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
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $upcoming = DB::table('provider_notifications')
            ->select('id', 'title', 'type', 'status', 'is_read', DB::raw('datediff(now(), date_booked) as tae'))
            ->where('clinic_id', $getClinicId[0])
            ->where('status', 7)
            ->WhereRaw('datediff(now(), date_booked) = 1');
        $notifications = DB::table('provider_notifications')
            ->select('id', 'title', 'type', 'status', 'is_read', DB::raw('NULL as tae'))
            ->where('clinic_id', $getClinicId[0])
            ->where('status', '<>', 7);
        $details = $upcoming->union($notifications)->get();
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
                ->select('booking.time_slot as created_at', 'booking.patient_id', 'users.name', 'booking.time_slot as date_booked', 'booking_time.time_slot', 'family_plan_type_subcategory.name as service_name', 'users.age', 'users.birth_date', 'users.contact_number_1 as contact_number', 'booking.referal', 'users.gender', 'users.email', DB::raw('null as family_plan_type'))
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

    public function badge($id)
    {
        $providerNotifications = new ProviderNotifications();
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $details = $providerNotifications->badge($getClinicId[0]);

        return response([
            'name' => 'badge',
            'details' => $details,
        ]);
    }

    public function upcomingBookingEmailNotif($id)
    {
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $getClinicEmail = DB::table('clinics')->select('email')->where('id', $getClinicId[0])->pluck('email');
        $upcoming = DB::table('booking')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->select('booking.id', 'family_plan_type_subcategory.name as service_name', 'users.name as patient_name', 'booking.time_slot as date_booked')
            ->where('booking.status', 1)
            ->whereRaw('DATEDIFF(booking.time_slot, CURDATE()) = 1')
            ->get();
        Mail::send('email.patient.provider.upcoming-booking', ['details' => $upcoming], function ($mail) use ($getClinicEmail) {
            $mail->from('notifications@friendlycare.com');
            $mail->to($getClinicEmail[0], 'Patient')->subject('Upcoming Booking');
        });

        return response([
            'name' => 'UpcomingBookingProvider',
            'details' => 'message sent',
        ]);
    }
}
