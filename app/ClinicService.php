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
            ->select('family_plan_type_subcategory.name as service_name')
            ->where('clinic_service.clinic_id', $id)
            ->get();
    }
}
