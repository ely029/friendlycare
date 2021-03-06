<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\ClinicService
 *
 * @property int $id
 * @property int|null $clinic_id
 * @property int|null $service_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $is_checked
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicService query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicService whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicService whereIsChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicService whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicService whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClinicService extends Model
{
    protected $table = 'clinic_service';
    protected $fillable = [
        'clinic_id',
        'service_id',
        'is_checked',
    ];

    public function getServices($id)
    {
        return DB::table('clinic_service')
            ->join('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'clinic_service.service_id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name as service_name')
            ->where('clinic_service.clinic_id', $id)
            ->get();
    }

    public function editPageModern($id)
    {
        return DB::table('family_plan_type_subcategory as fpm')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'fpm.id')
            ->select('fpm.id', 'fpm.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $id)
            ->where('fpm.family_plan_type_id', 1)
            ->get();
    }

    public function editPagePermanent($id)
    {
        return DB::table('family_plan_type_subcategory as fpm')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'fpm.id')
            ->select('fpm.id', 'fpm.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $id)
            ->where('fpm.family_plan_type_id', 2)
            ->get();
    }

    public function editPageNatural($id)
    {
        return DB::table('family_plan_type_subcategory as fpm')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'fpm.id')
            ->select('fpm.id', 'fpm.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $id)
            ->where('fpm.family_plan_type_id', 3)
            ->get();
    }

    public function createModernClinicService($request, $modern)
    {
        ClinicService::create([
            'service_id' => $request['available_service'][$modern],
            'clinic_id' => session('id'),
            'is_checked' => 1,
        ]);
    }

    public function createNaturalClinicService($request, $natural)
    {
        ClinicService::create([
            'service_id' => $request['natural'][$natural],
            'clinic_id' => session('id'),
            'is_checked' => 1,
        ]);
    }

    public function createPermanentClinicService($request, $permanent)
    {
        ClinicService::create([
            'service_id' => $request['permanent'][$permanent],
            'clinic_id' => session('id'),
            'is_checked' => 1,
        ]);
    }

    public function createUncheckedService($data)
    {
        ClinicService::create([
            'service_id' => $data->id,
            'clinic_id' => session('id'),
            'is_checked' => 0,
        ]);
    }

    public function createUncheckedService1($data, $request)
    {
        ClinicService::create([
            'service_id' => $data->id,
            'clinic_id' => $request['clinic_id'],
            'is_checked' => 0,
        ]);
    }

    public function updateClinicService($request, $eee)
    {
        ClinicService::create([
            'service_id' => $request['avail_services'][$eee],
            'clinic_id' => $request['clinic_id'],
            'is_checked' => 1,
        ]);
    }
}
