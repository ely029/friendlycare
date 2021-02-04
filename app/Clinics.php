<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Clinics extends Model
{
    protected $table = 'clinics';
    protected $fillable = [
        'user_id',
        'clinic_name',
        'contact_number',
        'location',
        'is_close',
        'close_message',
        'description',
        'profile_photo',
        'type',
        'profession',
        'training',
        'street_address',
        'city',
        'municipality',
        'province',
        'email',
        'photo_url',
        'philhealth_accredited_1',
        'region',
        'barangay',
        'province_id_string',
        'city_id_string',
        'region_id_string',
        'barangay_id_string',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function staff()
    {
        return $this->belongsTo('App\Staffs');
    }

    public function getProvider()
    {
        return DB::table('clinics')
            ->select('clinics.id', 'clinics.clinic_name')
            ->where('clinics.email', '<>', 'null')
            ->where('clinics.is_approve', '<>', 0)
            ->get();
    }
}
