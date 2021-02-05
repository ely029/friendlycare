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

    public function getClinicFirstScenario()
    {
        return DB::table('clinics')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 1)
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicSecondScenario()
    {
        return DB::table('clinics')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 0)
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicThirdScenario()
    {
        return DB::table('clinics')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 0)
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicFourthScenario()
    {
        return DB::table('clinics')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 1)
            ->where('clinics.philhealth_accredited_1', 0)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicFifthScenario($obj)
    {
        return DB::table('clinics')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 1)
            ->where('clinics.province', $obj['province'][0])
            ->where('clinics.city', $obj['city'][0])
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicSixthScenario($obj)
    {
        return DB::table('clinics')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 0)
            ->where('clinics.province', $obj['province'][0])
            ->where('clinics.city', $obj['city'][0])
            ->where('clinics.philhealth_accredited_1', 0)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicSeventhScenario($obj)
    {
        return DB::table('clinics')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 0)
            ->where('clinics.province', $obj['province'][0])
            ->where('clinics.city', $obj['city'][0])
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicEighthScenario($obj)
    {
        return DB::table('clinics')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 1)
            ->where('clinics.province', $obj['province'][0])
            ->where('clinics.city', $obj['city'][0])
            ->where('clinics.philhealth_accredited_1', 0)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicWithTaggedMethodFirstScenario($obj, $getMethod)
    {
        return DB::table('clinics')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinic_service.service_id', $getMethod[0])
            ->orWhere('clinics.province', $obj['province'][0])
            ->orWhere('clinics.city', $obj['city'][0])
            ->Where('clinics.paid_service', 1)
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getTaggedMethodFirstScenario($getMethod)
    {
        return DB::table('clinics')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinic_service.service_id', $getMethod[0])
            ->Where('clinics.paid_service', 0)
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getTaggedMethodSecondScenario($getMethod)
    {
        return DB::table('clinics')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinic_service.service_id', $getMethod[0])
            ->Where('clinics.paid_service', 1)
            ->where('clinics.philhealth_accredited_1', 0)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getTaggedMethodThirdScenario($getMethod)
    {
        return DB::table('clinics')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinic_service.service_id', $getMethod[0])
            ->Where('clinics.paid_service', 1)
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getTaggedMethodFourthScenario($getMethod)
    {
        return DB::table('clinics')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinic_service.service_id', $getMethod[0])
            ->Where('clinics.paid_service', 0)
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }
}
