<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FamilyPlanTypeSubcategories extends Model
{
    protected $table = 'family_plan_type_subcategory';
    protected $fillable = [
        'family_plan_type_id',
        'short_name',
        'name',
        'typical_validity',
        'percent_effective',
        'icon',
        'icon_url',
    ];

    public function serviceGalleries()
    {
        return $this->hasMany('App\ServiceGallery', 'service_id');
    }

    public function getUncheckedServices($id)
    {
        return DB::table('family_plan_type_subcategory')->select('id')->whereNotIn('id', function ($query) use ($id) {
            $query->select('service_id')->from('clinic_service')->where('clinic_id', $id);
        })->get();
    }

    public function getUncheckedPaidServices($id)
    {
        return DB::table('family_plan_type_subcategory')->select('id')->whereNotIn('id', function ($query) use ($id) {
            $query->select('service_id')->from('paid_services')->where('clinic_id', $id);
        })->get();
    }
}
