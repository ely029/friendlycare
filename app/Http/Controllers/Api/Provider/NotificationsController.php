<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Provider;

use Akaunting\Firewall\Provider;
use App\Booking;
use App\Clinics;
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
        $providerNotifications = new ProviderNotifications();
        $upcoming = $providerNotifications->getUpcoming($getClinicId);
        $notifications = DB::table('provider_notifications')
            ->select('id', 'title', 'type', 'status', 'is_read', DB::raw('NULL as count_date'))
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

    public function upcomingBookingEmailNotif()
    {
        $clinics = \App\Clinics::pluck('id', 'email');
        foreach ($clinics as $id => $email) {
            $checkBookingTommorow = Booking::whereRaw('datediff("'.date('Y-m-d').'", time_slot) = -1')->where('is_your_booking_tommorow', 1)->where('clinic_id', $email)->count();
            if ($checkBookingTommorow >= 1) {
                $upcoming = DB::table('booking')
                    ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
                    ->leftJoin('users', 'users.id', 'booking.patient_id')
                    ->select('booking.id', 'family_plan_type_subcategory.name as service_name', 'users.name as patient_name', 'booking.time_slot as date_booked')
                    ->where('booking.status', 1)
                    ->where('booking.clinic_id', $email)
                    ->where('booking.is_your_booking_tommorow', 1)
                    ->WhereRaw('datediff("'.date('Y-m-d').'", time_slot) = -1')
                    ->get();
                Mail::send('email.patient.provider.upcoming-booking', ['details' => $upcoming], function ($mail) use ($id) {
                    $mail->from('notifications@friendlycare.com');
                    $mail->to($id, 'Patient')->subject('Upcoming Booking');
                });
                DB::statement('update booking set is_your_booking_tommorow = 0 where clinic_id = ?', [$email]);
            }
        }
    }

    public function upcomingBookingEmailNotifPerClinic($id)
    {
        $getEmail = DB::table('clinics')->select('email')->where('id', $id)->pluck('email');
        $upcoming = DB::table('booking')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->select('booking.id', 'family_plan_type_subcategory.name as service_name', 'users.name as patient_name', 'booking.time_slot as date_booked')
            ->where('booking.status', 1)
            ->where('booking.clinic_id', $id)
            ->WhereRaw('datediff("'.date('Y-m-d').'", time_slot) = -1')
            ->get();
        Mail::send('email.patient.provider.upcoming-booking', ['details' => $upcoming], function ($mail) use ($getEmail) {
            $mail->from('notifications@friendlycare.com');
            $mail->to($getEmail[0], 'Patient')->subject('Upcoming Booking');
        });
    }
}
