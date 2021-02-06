<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
}
