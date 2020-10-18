<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    ];

    public function serviceGalleries()
    {
        return $this->hasMany('App\Servicegallery', 'service_id');
    }
}
