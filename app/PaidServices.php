<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PaidServices extends Model
{
    protected $table = 'paid_services';
    protected $fillable = [
        'service_id',
        'clinic_id',
        'is_checked',
    ];

    public function providerInformationPaidService($id)
    {
        return DB::table('paid_services')
            ->join('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'paid_services.service_id')
            ->select('family_plan_type_subcategory.name')
            ->where('paid_services.clinic_id', $id)
            ->get();
    }

    public function editPageModern($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'family_plan_type_subcategory.short_name', 'paid_services.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('paid_services.clinic_id', $id)
            ->get();
    }

    public function editPagePermanent($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'family_plan_type_subcategory.short_name', 'paid_services.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('paid_services.clinic_id', $id)
            ->get();
    }

    public function editPageNatural($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'family_plan_type_subcategory.short_name', 'paid_services.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('paid_services.clinic_id', $id)
            ->get();
    }
}
