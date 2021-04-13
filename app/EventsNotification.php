<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\EventsNotification
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $message
 * @property int|null $type
 * @property int|null $schedule
 * @property int|null $is_approve
 * @property string|null $date_string
 * @property string|null $date_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date
 * @property string|null $time
 * @property int|null $patient_id
 * @property int|null $is_read
 * @property string|null $display_type
 * @property int|null $status
 * @property int|null $appointment_date
 * @property int|null $clinic_name
 * @property int|null $is_rated
 * @property string|null $clinic_name_1
 * @property string|null $appointement_date_1
 * @property int|null $booking_id
 * @property string|null $scheduled
 * @property string|null $survey_link
 * @property string|null $survey_date_from_string
 * @property string|null $survey_date_to_string
 * @property int|null $survey_id
 * @property string|null $events_display
 * @property string|null $date_time_string
 * @property int|null $events_scheduled_display
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereAppointementDate1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereAppointmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereClinicName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereClinicName1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereDateString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereDateTimeString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereDisplayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereEventsDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereEventsScheduledDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereIsApprove($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereIsRated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereScheduled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereSurveyDateFromString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereSurveyDateToString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereSurveyLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventsNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        return DB::select('
        select 
        id, 
        title, 
        display_type as type, 
        is_read
        from events_notification
        where date_string <= '.strtotime(date('Y-m-d')).'
        and Scheduled = "Scheduled"
        AND display_type = "Announcements"
        
        UNION ALL

        select 
        id, 
        title, 
        display_type as type, 
        is_read
        from events_notification
        where date_string <= '.strtotime(date('Y-m-d')).'
        and Scheduled = "Scheduled"
        AND display_type = "Events"
        
        UNION ALL

        select 
        id, 
        title, 
        display_type as type, 
        is_read
        from events_notification
        WHERE
        Scheduled = "Post Now"
        AND display_type = "Announcements"
        
        UNION ALL

        select 
        id, 
        title, 
        display_type as type, 
        is_read
        from events_notification
        where
        Scheduled = "Post Now"
        AND display_type = "Events"
        
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
        ', [$id]);
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
            ->where('date_string', '<', strtotime(date('Y-m-d')))
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
            ->where('date_string', '<', strtotime(date('Y-m-d')))
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

    public function createSurveyNotification($request, $id)
    {
        EventsNotification::create([
            'title' => $request['title'],
            'message' => $request['message'],
            'type' => 6,
            'survey_link' => $request['link'],
            'survey_date_from_string' => $request['date_from_datestring'],
            'survey_date_to_string' => $request['date_to_datestring'],
            'survey_id' => $id[0],
        ]);
    }
}
