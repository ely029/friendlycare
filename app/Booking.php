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

    public function getBookingByPatient($patient_id)
    {
        return DB::table('booking')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->select('users.id as user_id', 'booking.id as booking_id', 'users.name', 'family_plan_type_subcategory.name as service_name', 'booking.time_slot', 'booking.status')
            ->where('booking.patient_id', $patient_id)
            ->where('booking.is_booked', 1)
            ->get();
    }
}
