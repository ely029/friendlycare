<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProviderNotifications extends Model
{
    protected $table = 'provider_notifications';
    protected $fillable = [
        'clinic_id',
        'type',
        'message',
        'title',
        'booking_id',
        'status',
        'display_type',
        'patient_id',
    ];

    public function checkUpComingBooking()
    {
        return DB::insert('INSERT IGNORE INTO provider_notifications(title, message, display_type, patient_id, status, booking_id, clinic_id, type) select 
        "Upcoming Booking Tommorow" as title, 
        NULL as message, 
        "Notifications" as display_type, 
        patient_id, 
        7 as status, 
        id as booking_id,
        clinic_id,
        "Notifications" 
        from booking
        WHERE  DATEDIFF(time_slot, CURDATE()) = 1 and is_updated = 0');
    }

    public function isUpdated()
    {
        return DB::statement('update booking set is_updated = 1 WHERE  TIMESTAMPDIFF(DAY, time_slot, CURDATE())');
    }
}
