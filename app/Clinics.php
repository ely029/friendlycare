<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Clinics
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $clinic_name
 * @property string|null $contact_number
 * @property string|null $location
 * @property int $is_close
 * @property int $is_approve
 * @property string|null $close_message
 * @property string|null $description
 * @property string|null $profile_photo
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $profession
 * @property string $training
 * @property string|null $street_address
 * @property string|null $city
 * @property string|null $municipality
 * @property string|null $province
 * @property string|null $email
 * @property string|null $photo_url
 * @property int|null $paid_service
 * @property int|null $philhealth_accredited_1
 * @property string|null $region_id_string
 * @property string|null $province_id_string
 * @property string|null $city_id_string
 * @property string|null $region
 * @property string|null $barangay
 * @property string|null $barangay_id_string
 * @property-read \App\Staffs $staff
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics query()
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereBarangayIdString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereCityIdString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereClinicName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereCloseMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereIsApprove($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereIsClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereMunicipality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics wherePaidService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics wherePhilhealthAccredited1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics wherePhotoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereProfilePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereProvinceIdString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereRegionIdString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereStreetAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereTraining($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinics whereUserId($value)
 * @mixin \Eloquent
 */
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
            ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 0)
            ->where('clinic_service.is_checked', 1)
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->where('clinics.is_approve', 1)
            ->where('clinics.is_close', '<>', 1)
            ->distinct('clinics.clinic_name')
            ->get();
    }

    public function getClinicSecondScenario()
    {
        return DB::table('clinics')
            ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.user_id', 0)
            ->where('clinic_service.is_checked', 1)
            ->where('clinics.is_close', '<>', 1)
            ->where('clinics.is_approve', 1)
            ->distinct('clinics.clinic_name')
            ->get();
    }

    public function getClinicThirdScenario()
    {
        return DB::table('clinics')
            ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->where('clinic_service.is_checked', 1)
            ->where('clinics.is_close', '<>', 1)
            ->where('clinics.is_approve', 1)
            ->distinct('clinics.clinic_name')
            ->get();
    }

    public function getClinicFourthScenario()
    {
        return DB::table('clinics')
            ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 1)
            ->where('clinics.user_id', 0)
            ->where('clinic_service.is_checked', 1)
            ->where('clinics.is_close', '<>', 1)
            ->where('clinics.is_approve', 1)
            ->distinct('clinics.clinic_name')
            ->get();
    }

    public function getClinicFifthScenario($obj)
    {
        return DB::table('clinics')
            ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.province', $obj['province'][0])
            ->where('clinics.city', $obj['city'][0])
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->where('clinic_service.is_checked', 1)
            ->where('clinics.is_approve', 1)
            ->where('clinics.is_close', '<>', 1)
            ->distinct('clinics.clinic_name')
            ->get();
    }

    public function getClinicSixthScenario($obj)
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.province', $obj['province'][0])
            ->where('clinics.city', $obj['city'][0])
            ->where('clinics.user_id', 0)
            ->where('clinic_service.is_checked', 1)
            ->where('clinics.is_approve', 1)
            ->where('clinics.is_close', '<>', 1)
            ->distinct('clinics.clinic_name')
            ->get();
    }

    public function getClinicSeventhScenario($obj)
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.province', $obj['province'][0])
            ->where('clinics.city', $obj['city'][0])
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.user_id', 0)
            ->where('clinic_service.is_checked', 1)
            ->where('clinics.is_approve', 1)
            ->distinct('clinics.clinic_name')
            ->get();
    }

    public function getClinicEighthScenario($obj)
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 1)
            ->where('clinics.province', $obj['province'][0])
            ->where('clinics.city', $obj['city'][0])
            ->where('clinics.user_id', 0)
            ->where('clinic_service.is_checked', 1)
            ->where('clinics.is_close', '<>', 1)
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

    public function getTaggedMethodFirstScenario($method)
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.paid_service', 0)
            ->where('clinic_service.service_id', $method)
            ->where('clinics.is_close', '<>', 1)
            ->where('clinics.is_approve', 1)
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinic_service.is_checked', 1)
            ->where('clinics.user_id', 0)
            ->get();
    }

    public function getTaggedMethodSecondScenario($method)
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.user_id', 0)
            ->where('clinic_service.service_id', $method)
            ->where('clinics.is_approve', 1)
            ->where('clinics.is_close', '<>', 1)
            ->where('clinic_service.is_checked', 1)
            ->get();
    }

    public function getTaggedMethodThirdScenario($method)
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->where('clinics.philhealth_accredited_1', 1)
            ->where('clinics.is_close', '<>', 1)
            ->where('clinic_service.service_id', $method)
            ->where('clinics.user_id', 0)
            ->where('clinic_service.is_checked', 1)
            ->where('clinics.is_approve', 1)
            ->get();
    }

    public function getTaggedMethodFourthScenario($method)
    {
        return DB::table('clinics')
            ->distinct('clinics.clinic_name')
            ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
            ->Where('clinics.paid_service', 1)
            ->where('clinics.is_approve', 1)
            ->where('clinics_service.is_checked', 1)
            ->where('clinic_service.service_id', $method)
            ->where('clinics.is_close', '<>', 1)
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

    public function updateProviderWithProfilePhoto($request)
    {
        return Clinics::where('id', $request['clinic_id'])->update([
            'clinic_name' => $request['clinic_name'] ?? null,
            'street_address' => $request['street_address'] ?? null,
            'description' => $request['description'] ?? null,
            'contact_number' => $request['contact_number'] ?? null,
            'city' => $request['city'] ?? '',
            'province' => $request['province'] ?? '',
            'email' => $request['email'],
            'region' => $request['region'] ?? '',
            'type' => $request['type'] ?? null,
            'paid_service' => $request['paid'] ?? null,
            'barangay' => $request['barangay'] ?? null,
            'photo_url' => $request['pic_url'] ?? null,
            'barangay_id_string' => $request['barangay_id_string'],
            'region_id_string' => $request['region_id_string'] ?? '',
            'province_id_string' => $request['province_id_string'] ?? '',
            'city_id_string' => $request['city_id_string'] ?? '',
            'philhealth_accredited_1' => $request['philhealth_accredited_1'],
        ]);
    }

    public function updateProviderWithoutProfilePhoto($request)
    {
        return Clinics::where('id', $request['clinic_id'])->update([
            'clinic_name' => $request['clinic_name'] ?? null,
            'street_address' => $request['street_address'] ?? null,
            'description' => $request['description'] ?? null,
            'contact_number' => $request['contact_number'] ?? null,
            'city' => $request['city'] ?? '',
            'province' => $request['province'] ?? '',
            'email' => $request['email'] ?? null,
            'region' => $request['region'] ?? '',
            'type' => $request['type'] ?? null,
            'paid_service' => $request['paid'] ?? null,
            'barangay' => $request['barangay'] ?? null,
            'barangay_id_string' => $request['barangay_id_string'] ?? null,
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

    public function getClinic()
    {
        return DB::table('clinics')
            ->select('id', 'clinic_name')
            ->where('clinic_name', '<>', null)
            ->where('type', '<>', null)
            ->where('philhealth_accredited_1', '<>', null)
            ->where('is_approve', 1)
            ->where('user_id', 0)
            ->get();
    }

    public function getClinicByStaff($id)
    {
        return DB::table('clinics')
            ->join('staffs', 'staffs.clinic_id', 'clinics.id')
            ->select('clinics.clinic_name')
            ->where('staffs.user_id', $id)
            ->get();
    }

    public function getClinicByStaffOne($id)
    {
        return DB::table('staffs')
            ->leftJoin('clinics', 'clinics.id', 'staffs.clinic_id')
            ->select('clinics.clinic_name')
            ->where('staffs.user_id', $id)
            ->get();
    }

    public function getBarangayManila()
    {
        return DB::table('refbrgy')->select('brgyCode as barangay_code', 'brgyDesc as barangay_description')->where('citymuncode', '133901')
            ->orWhere('citymuncode', '133902')
            ->orWhere('citymuncode', '133903')
            ->orWhere('citymuncode', '133904')
            ->orWhere('citymuncode', '133905')
            ->orWhere('citymuncode', '133906')
            ->orWhere('citymuncode', '133907')
            ->orWhere('citymuncode', '133908')
            ->orWhere('citymuncode', '133909')
            ->orWhere('citymuncode', '133910')
            ->orWhere('citymuncode', '133911')
            ->orWhere('citymuncode', '133912')
            ->orWhere('citymuncode', '133913')
            ->orWhere('citymuncode', '133914')
            ->get();
    }

    public function clinicName($id)
    {
        return DB::table('clinics')
            ->leftJoin('ratings', 'ratings.clinic_id', 'clinics.id')
            ->select('clinics.clinic_name', 'clinics.contact_number', 'clinics.email', 'clinics.photo_url')
            ->where('clinics.id', $id)
            ->distinct('clinics.clinic_name')
            ->get();
    }

    public function details($id)
    {
        return DB::table('clinics')
            ->select(
            'clinics.id',
            'clinics.email',
            'clinics.contact_number as contact_number',
            'clinics.street_address',
            'clinics.description',
            'clinics.clinic_name',
            'clinics.city',
            'clinics.province',
            'clinics.municipality',
            'clinics.photo_url',
            'clinics.type',
            )
            ->where('clinics.id', $id)
            ->where('is_approve', 1)
            ->get();
    }
}
