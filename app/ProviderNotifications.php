<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\ProviderNotifications
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $message
 * @property string|null $type
 * @property int|null $clinic_id
 * @property int|null $status
 * @property int|null $booking_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $is_read
 * @property string|null $display_type
 * @property int|null $patient_id
 * @property string|null $date_booked
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications whereDateBooked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications whereDisplayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProviderNotifications whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        'date_booked',
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
        WHERE  DATEDIFF(time_slot, CURDATE()) = 1');
    }

    public function isUpdated()
    {
        return DB::statement('update booking set is_updated = 1 WHERE  TIMESTAMPDIFF(DAY, time_slot, CURDATE())');
    }

    public function badge($id)
    {
        $details = DB::table('provider_notifications')->select('id')->where('is_read', 0)->where('clinic_id', $id)->count();

        if ($details < 1) {
            return false;
        }
        return true;
    }

    public function createNotification($getPatientId, $getClinicId, $getBookedDate, $id)
    {
        ProviderNotifications::create([
            'patient_id' => $getPatientId[0],
            'title' => 'Upcoming Booking Tommorow',
            'type' => 'Notifications',
            'message' => null,
            'status' => 7,
            'booking_id' => $id,
            'clinic_id' => $getClinicId[0],
            'date_booked' => $getBookedDate->time_slot,
        ]);
    }

    public function cancellationNotifications($getPatientName, $getClinicId, $id)
    {
        ProviderNotifications::create([
            'title' => 'Patient cancelled',
            'message' => 'Your patient '.$getPatientName[0].' has been cancelled',
            'clinic_id' => $getClinicId[0],
            'type' => 'Notifications',
            'booking_id' => $id,
            'status' => 2,
        ]);
    }

    public function accountDisabledNotification($request)
    {
        ProviderNotifications::create([
            'title' => 'Clinic is activated',
            'message' => 'Your clinic is activated',
            'clinic_id' => $request['id'],
            'type' => 'Update',
            'booking_id' => 0,
            'status' => 1,
        ]);
    }

    public function accountEnabledNotification($request)
    {
        ProviderNotifications::create([
            'title' => 'Clinic is deactivated',
            'message' => 'Your clinic is deactivated',
            'clinic_id' => $request['id'],
            'type' => 'Update',
            'booking_id' => 0,
            'status' => 1,
        ]);
    }

    public function clinicUpdateNotification($request)
    {
        ProviderNotifications::create([
            'title' => 'Clinic Information are updated',
            'message' => 'Your clinic had updated some of the information.',
            'clinic_id' => $request['clinic_id'],
            'type' => 'Update',
            'booking_id' => 0,
            'status' => 0,
        ]);
    }

    public function getUpcoming($getClinicId)
    {
        return DB::table('provider_notifications')
            ->select('id', 'title', 'type', 'status', 'is_read', DB::raw('datediff("'.date('Y-m-d').'", date_booked) as count_date'))
            ->where('clinic_id', $getClinicId[0])
            ->where('status', 7)
            ->where('message', null)
            ->where('display_type', null)
            ->WhereRaw('datediff("'.date('Y-m-d').'", date_booked) = -1');
    }

    public function getNotifications($getClinicId)
    {
        return DB::table('provider_notifications')
            ->select('id', 'title', 'type', 'status', 'is_read', DB::raw('NULL as count_date'))
            ->where('clinic_id', $getClinicId[0])
            ->where('status', '<>', 7);
    }
}
