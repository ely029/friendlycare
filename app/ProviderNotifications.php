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
}
