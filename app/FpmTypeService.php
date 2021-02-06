<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
