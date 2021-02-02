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
        'time_from',
        'time_to',
        'end_time',
        'new_request_end_time',
        'is_rated',
    ];

    public function getNewRequestBooking($clinic_id)
    {
        return DB::table('booking')
            ->join('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->join('users', 'users.id', 'booking.patient_id')
            ->join('booking_time', 'booking_time.booking_id', 'booking.id')
            ->select('users.id as user_id', 'booking.is_read', 'booking.id as booking_id', 'users.name', 'family_plan_type_subcategory.name as service_name', 'booking_time.time_slot', 'booking.status', 'booking.time_slot as date_booked')
            ->where('booking.clinic_id', $clinic_id)
            ->get();
    }

    public function getBookings($clinic_id, $date)
    {
        return DB::table('booking')
            ->join('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->join('users', 'users.id', 'booking.patient_id')
            ->join('booking_time', 'booking_time.booking_id', 'booking.id')
            ->select('users.id as user_id', 'booking.is_read', 'booking.id as booking_id', 'users.name', 'family_plan_type_subcategory.name as service_name', 'booking_time.time_slot', 'booking.status', 'booking.time_slot as date_booked')
            ->where('booking.clinic_id', $clinic_id)
            ->where('booking.time_slot', $date)
            ->where('booking.is_approved', 1)
            ->where('booking.status', '<>', 6)
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
            ->where('booking.status', '<>', 3)
            ->where('booking.is_approved', 1)
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
            ->where('booking.is_approved', 1)
            ->where('booking.time_slot', $date)
            ->orderBy('booking_time.time_slot')
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

    public function getRescheduleDetails($id)
    {
        return DB::table('booking')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('booking_time', 'booking_time.booking_id', 'booking.id')
            ->select('users.id as patient_id', 'booking.id as booking_id', 'users.name as patient_name', 'booking.time_slot as date_booked', 'family_plan_type_subcategory.name as service_name', 'booking_time.time_slot', 'users.email', 'users.contact_number_1 as contact_number')
            ->where('booking.id', $id)
            ->get();
    }

    public function getConfirmServiceDetails($id)
    {
        return DB::table('booking')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->leftJoin('booking_time', 'booking_time.booking_id', 'booking.id')
            ->select('users.name', 'booking.time_slot as date_booked', 'booking_time.time_slot', 'family_plan_type_subcategory.name as service_avail')
            ->where('booking.id', $id)
            ->get();
    }

    public function getInboxDetails($id)
    {
        return DB::table('booking')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftjoin('clinics', 'booking.clinic_id', 'clinics.id')
            ->leftJoin('booking_time', 'booking_time.booking_id', 'booking.id')
            ->select('users.id as user_id', 'booking.is_read_patient_booking', 'booking.id as booking_id', 'booking.time_slot as date_booked', 'booking_time.time_slot', 'booking.status', 'clinics.clinic_name')
            ->where('booking.patient_id', $id)
            ->where('booking.status', '<>', 5)
            ->where('booking.status', '<>', 3)
            ->get();
    }

    public function getInboxPerBooking($id)
    {
        return DB::table('booking')
            ->leftJoin('clinics', 'booking.clinic_id', 'clinics.id')
            ->leftJoin('booking_time', 'booking.id', 'booking_time.booking_id')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->select('users.id as user_id', 'booking.id as booking_id', 'clinics.clinic_name', 'booking.time_slot as date_booked', 'booking_time.time_slot', 'booking.status', 'family_plan_type_subcategory.name as service_name', 'clinics.email', 'clinics.contact_number', 'clinics.street_address', 'booking.is_rated')
            ->where('booking.id', $id)
            ->get();
    }

    public function filterPerStatus($id, $obj)
    {
        return DB::table('booking')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('clinics', 'booking.clinic_id', 'clinics.id')
            ->leftJoin('booking_time', 'booking_time.booking_id', 'booking.id')
            ->select('users.id as user_id', 'booking.id as booking_id', 'booking.is_read_patient_booking', 'booking.time_slot as date_booked', 'booking_time.time_slot', 'booking.status', 'clinics.clinic_name')
            ->where('booking.patient_id', $id)
            ->where('booking.status', $obj['status'][0])
            ->get();
    }

    public function checkBooking($clinic_id, $obj)
    {
        return DB::table('booking_time')
            ->leftJoin('booking', 'booking.id', 'booking_time.booking_id')
            ->select('booking_time.id')->where('booking.clinic_id', $clinic_id)->where('booking.time_slot', $obj['time'][0])->count();
    }
}
