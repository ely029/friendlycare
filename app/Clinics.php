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
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 0)
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicSecondScenario()
    {
        return DB::table('clinics')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicThirdScenario()
    {
        return DB::table('clinics')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicFourthScenario()
    {
        return DB::table('clinics')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicFifthScenario($obj)
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.province', $obj['province'][0])
            ->where('clinics.city', $obj['city'][0])
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicSixthScenario($obj)
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.province', $obj['province'][0])
            ->where('clinics.city', $obj['city'][0])
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicSeventhScenario($obj)
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.province', $obj['province'][0])
            ->where('clinics.city', $obj['city'][0])
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getClinicEighthScenario($obj)
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 1)
            ->where('clinics.province', $obj['province'][0])
            ->where('clinics.city', $obj['city'][0])
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

    public function getTaggedMethodFirstScenario()
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.paid_service', 0)
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getTaggedMethodSecondScenario()
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getTaggedMethodThirdScenario()
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getTaggedMethodFourthScenario()
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getSelectedClinic($id)
    {
        return DB::table('clinics')
            ->leftJoin('paid_services', 'paid_services.clinic_id', 'clinics.id')
            ->select('clinics.id', 'paid_services.id as free_consultation', 'clinics.photo_url', 'clinics.clinic_name', 'clinics.street_address', 'clinics.type', 'clinics.philhealth_accredited_1')
            ->where('clinics.id', $id)
            ->get();
    }

    public function updateProvider($request)
    {
        return Clinics::where('id', $request['clinic_id'])->update([
            'clinic_name' => $request['clinic_name'],
            'street_address' => $request['street_address'],
            'description' => $request['description'],
            'contact_number' => $request['contact_number'],
            'city' => $request['city'] ?? '',
            'province' => $request['province'] ?? '',
            'email' => $request['email'],
            'region' => $request['region'] ?? '',
            'type' => $request['type'],
            'paid_service' => $request['paid'],
            'barangay' => $request['barangay'],
            'photo_url' => $request['pic_url'],
            'barangay_id_string' => $request['barangay_id_string'],
            'region_id_string' => $request['region_id_string'] ?? '',
            'province_id_string' => $request['province_id_string'] ?? '',
            'city_id_string' => $request['city_id_string'] ?? '',
            'philhealth_accredited_1' => $request['philhealth_accredited_1'],
        ]);
    }

    public function getInformation($id)
    {
        return DB::table('clinics')
            ->select(
            'clinics.clinic_name',
            'clinics.city',
            'clinics.province',
            'clinics.contact_number',
            'clinics.municipality',
            'clinics.email',
            'clinics.description',
            'clinics.type',
            'clinics.street_address',
            'clinics.id',
            'clinics.paid_service',
            'clinics.philhealth_accredited_1',
            'clinics.photo_url',
            'clinics.region',
            'clinics.region_id_string',
            'clinics.province_id_string',
            'clinics.barangay_id_string',
            'clinics.city_id_string',
            'clinics.province',
            'clinics.city',
            'clinics.barangay',
           )
            ->where('clinics.id', $id)
            ->get();
    }

    public function editProviderInformation($id)
    {
        return DB::table('clinics')
            ->select(
            'clinics.clinic_name',
            'clinics.city',
            'clinics.province',
            'clinics.contact_number',
            'clinics.municipality',
            'clinics.email',
            'clinics.description',
            'clinics.type',
            'clinics.street_address',
            'clinics.id',
            'clinics.is_close',
            'clinics.philhealth_accredited_1',
            'clinics.photo_url',
       )
            ->where(['clinics.id' => $id, 'clinics.is_approve' => 1])
            ->whereNotNull('clinics.clinic_name')
            ->get();
    }

    public function indexPage()
    {
        return DB::table('clinics')
            ->leftJoin('staffs', 'staffs.clinic_id', 'clinics.id')
            ->leftJoin('ratings', 'ratings.clinic_id', 'clinics.id')
            ->leftJoin('ratings_details', 'ratings_details.rating_id', 'ratings.id')
            ->select('clinics.email', 'clinics.type', 'clinics.id', 'clinics.clinic_name', DB::raw('count(staffs.id) as number_staff'), DB::raw('avg(ratings_details.ratings) as avg'))
            ->where('clinics.email', '<>', 'null')
            ->where('clinics.is_approve', '<>', 0)
            ->groupBy(['clinics.email', 'clinics.type', 'clinics.id', 'clinics.clinic_name'])
            ->get();
    }
}
