<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    protected $table = 'booking';

    protected $fillable = [
        'service_id',
        'patient_id',
        'is_cancelled',
        'is_approved',
        'time_slot',
        'clinic_id',
        'referal',
    ];

    public function getNewRequestBooking($clinic_id)
    {
        return DB::table('booking')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->leftJoin('booking_time', 'booking_time.booking_id', 'booking.id')
            ->select('users.id as user_id', 'booking.is_read', 'booking.id as booking_id', 'users.name', 'family_plan_type_subcategory.name as service_name', 'booking_time.time_slot', 'booking.status', 'booking.time_slot as date_booked')
            ->where('booking.clinic_id', $clinic_id)
            ->where('booking.is_booked', 1)
            ->where('booking.status', null)
            ->get();
    }

    public function getBookings($clinic_id, $date)
    {
        return DB::table('booking')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->leftJoin('booking_time', 'booking_time.booking_id', 'booking.id')
            ->select('users.id as user_id', 'booking.is_read', 'booking.id as booking_id', 'users.name', 'family_plan_type_subcategory.name as service_name', 'booking_time.time_slot', 'booking.status', 'booking.time_slot as date_booked')
            ->where('booking.clinic_id', $clinic_id)
            ->where('booking.is_booked', 1)
            ->where('booking.status', '<>', null)
            ->whereBetween('booking.time_slot', [$date, $date])
            ->get();
    }

    public function getBookingsYesterday($clinic_id, $date)
    {
        return DB::table('booking')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->leftJoin('booking_time', 'booking_time.booking_id', 'booking.id')
            ->select('users.id as user_id', 'booking.is_read', 'booking.id as booking_id', 'users.name', 'family_plan_type_subcategory.name as service_name', 'booking_time.time_slot', 'booking.status', 'booking.time_slot as date_booked')
            ->where('booking.clinic_id', $clinic_id)
            ->where('booking.is_booked', 1)
            ->where('booking.status', '<>', null)
            ->where('booking.time_slot', $date)
            ->get();
    }

    public function getBookingsTommorow($clinic_id, $date)
    {
        return DB::table('booking')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->leftJoin('booking_time', 'booking_time.booking_id', 'booking.id')
            ->select('users.id as user_id', 'booking.is_read', 'booking.id as booking_id', 'users.name', 'family_plan_type_subcategory.name as service_name', 'booking_time.time_slot', 'booking.status', 'booking.time_slot as date_booked')
            ->where('booking.clinic_id', $clinic_id)
            ->where('booking.is_booked', 1)
            ->where('booking.status', '<>', null)
            ->where('booking.time_slot', $date)
            ->get();
    }

    public function bookingsDatePicker($clinic_id, $obj)
    {
        return DB::table('booking')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->leftJoin('booking_time', 'booking_time.booking_id', 'booking.id')
            ->select('users.id as user_id', 'booking.is_read', 'booking.id as booking_id', 'users.name', 'family_plan_type_subcategory.name as service_name', 'booking_time.time_slot', 'booking.status', 'booking.time_slot as date_booked')
            ->where('booking.clinic_id', $clinic_id)
            ->where('booking.is_booked', 1)
            ->where('booking.status', '<>', null)
            ->where('booking.time_slot', $obj['date'][0])
            ->get();
    }

    public function getBookingById($id)
    {
        return DB::table('booking')
            ->join('users', 'users.id', 'booking.patient_id')
            ->join('patients', 'patients.user_id', 'users.id')
            ->join('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->join('booking_time', 'booking_time.booking_id', 'booking.id')
            ->select('users.id as patient_id', 'family_plan_type_subcategory.name as service_name', 'users.contact_number_1 as contact_number', 'users.name as patient_name', 'booking.time_slot as date_booked', 'booking_time.time_slot', 'booking.status', 'users.age', 'users.birth_date', 'users.gender', 'users.email', 'patients.family_plan_type_id', 'booking.referal')
            ->where('booking.id', $id)
            ->where('booking.is_booked', 1)
            ->get();
    }

    public function cancellationDetails($id)
    {
        return DB::table('booking')
            ->leftJoin('users', 'booking.patient_id', 'users.id')
            ->leftJoin('booking_time', 'booking.id', 'booking_time.booking_id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->select('users.name', 'booking.time_slot as date_booked', 'booking_time.time_slot', 'family_plan_type_subcategory.name as service_name', 'users.email', 'users.contact_number_1 as contact_number')
            ->where('booking.id', $id)
            ->get();
    }
}
