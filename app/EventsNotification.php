<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EventsNotification extends Model
{
    protected $table = 'events_notification';

    protected $fillable = [
        'title',
        'message',
        'type',
        'schedule',
        'date_string',
        'date',
        'time',
        'is_approve',
        'patient_id',
        'display_type',
        'status',
        'appointment_date',
        'clinic_name',
        'clinic_name_1',
        'is_rated',
        'appointement_date_1',
        'booking_id',
        'scheduled',
        'survey_link',
        'survey_date_from_string',
        'survey_date_to_string',
    ];

    public function getPatientNotifications($id)
    {
        return DB::select('select 
        id, 
        title, 
        display_type as type, 
        is_read
        from events_notification
        where date_string >= '.strtotime(date('Y-m-d')).'
        AND patient_id = ?
        OR display_type = "Announcements"
        OR  display_type = "Events"
        
        UNION ALL

        select 
        id,
        title,
        display_type as type,
        is_read 
        from events_notification
        WHERE patient_id = ?
        AND display_type = "Notifications"

        UNION ALL

        select
        id,
        title,
        type,
        is_read
        from events_notification
        WHERE type = 6
        AND survey_date_to_string >= '.strtotime(date('Y-m-d')).' 
        ', [$id, $id]);
    }

    public function checkUpComingBooking()
    {
        return DB::insert('INSERT IGNORE INTO events_notification(title, message, display_type, patient_id, status, booking_id) select 
        "Upcoming Booking Tommorow" as title, 
        NULL as message, 
        "Notifications" as display_type, 
        patient_id, 
        7 as status, 
        id as booking_id from booking
        WHERE  DATEDIFF(time_slot, CURDATE()) = 1');
    }
}
