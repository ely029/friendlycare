<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\FpmTypeService
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int|null $service_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $is_checked
 * @method static \Illuminate\Database\Eloquent\Builder|FpmTypeService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FpmTypeService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FpmTypeService query()
 * @method static \Illuminate\Database\Eloquent\Builder|FpmTypeService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FpmTypeService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FpmTypeService whereIsChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FpmTypeService wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FpmTypeService whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FpmTypeService whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FpmTypeService extends Model
{
    protected $table = 'fpm_type_service';
    protected $fillable = [
        'patient_id',
        'service_id',
        'is_checked',
    ];

    public function getService($id)
    {
        return DB::table('fpm_type_service')->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name')
            ->where('fpm_type_service.patient_id', $id)
            ->get();
    }

    public function patientManagementInformation($id)
    {
        return DB::table('fpm_type_service')->join('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
            ->select('family_plan_type_subcategory.name')
            ->where('fpm_type_service.patient_id', $id)
            ->get();
    }
}
