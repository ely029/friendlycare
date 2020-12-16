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
    ];

    public function getPatientNotifications($id)
    {
        return DB::select('select 
        id, 
        title, 
        display_type as type, 
        is_read
        from events_notification
        AND patient_id = ?
        AND  display_type = "Events"
        
        UNION ALL
        
        select
        id, 
        title, 
        display_type as type, 
        is_read
        from events_notification
        AND patient_id = ?
        AND  display_type = "Announcements"

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
        ', [$id, $id, $id]);
    }
}
