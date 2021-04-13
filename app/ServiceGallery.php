<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ServiceGallery
 *
 * @property int $id
 * @property int $service_id
 * @property string|null $file_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $file_url
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceGallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceGallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceGallery query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceGallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceGallery whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceGallery whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceGallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceGallery whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceGallery whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
