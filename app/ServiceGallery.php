<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceGallery extends Model
{
    protected $table = 'service_gallery';
    protected $fillable = [
        'service_id',
        'file_name',
        'file_url',
    ];

    public function familyPlanTypeSubCategory()
    {
        $this->belongsTo('App\FamilyPlanTypeSubcategories');
    }

    public function generateServicePics($requests, $icon_url, $eee)
    {
        ServiceGallery::create([
            'file_name' => $requests['service_gallery_pics'][$eee],
            'service_id' => $requests['id'],
            'file_url' => $icon_url,
        ]);
    }
}
