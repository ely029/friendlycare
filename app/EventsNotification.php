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
        'survey_id',
        'events_display',
        'created_at',
        'updated_at',
        'date_time_string',
        'events_scheduled_display',
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

    public function upcomingEvents()
    {
        return DB::table('events_notification')
            ->select('id', 'title', 'date', 'type')
            ->where('is_approve', 1)
            ->where('type', 1)
            ->where('date_string', '>=', strtotime(date('Y-m-d')))
            ->get();
    }

    public function pastEvent()
    {
        return DB::table('events_notification')
            ->select('id', 'title', 'date', 'type')
            ->where('is_approve', 1)
            ->where('type', 1)
            ->where('date_string', '<=', strtotime(date('Y-m-d')))
            ->get();
    }

    public function upcomingAnnouncement()
    {
        return DB::table('events_notification')
            ->select('id', 'title', 'date', 'type')
            ->where('is_approve', 1)
            ->where('type', 2)
            ->where('date_string', '>=', strtotime(date('Y-m-d')))
            ->get();
    }

    public function pastAnnouncement()
    {
        return DB::table('events_notification')
            ->select('id', 'title', 'date', 'type')
            ->where('is_approve', 1)
            ->where('type', 2)
            ->where('date_string', '<=', strtotime(date('Y-m-d')))
            ->get();
    }

    public function createNotification($getPatientId, $message, $getDate, $id)
    {
        EventsNotification::create([
            'patient_id' => $getPatientId[0],
            'message' => '',
            'clinic_name_1' => $message,
            'display_type' => 'Notifications',
            'title' => 'Booking Accepted',
            'appointement_date_1' => $getDate[0],
            'booking_id' => $id,
        ]);
    }

    public function cancellationNotifications($getPatientId, $message, $getPatientDate)
    {
        EventsNotification::create([
            'patient_id' => $getPatientId[0],
            'message' => '',
            'clinic_name_1' => $message,
            'appointement_date_1' => $getPatientDate[0],
            'display_type' => 'Notifications',
            'title' => 'Booking Cancelled',
            'status' => 3,
        ]);
    }
}
