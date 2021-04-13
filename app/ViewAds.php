<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ViewAds
 *
 * @property int $id
 * @property string|null $views
 * @property int|null $ads_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ViewAds newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ViewAds newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ViewAds query()
 * @method static \Illuminate\Database\Eloquent\Builder|ViewAds whereAdsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ViewAds whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ViewAds whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ViewAds whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ViewAds whereViews($value)
 * @mixin \Eloquent
 */
class ViewAds extends Model
{
    protected $table = 'ad_views';
    protected $fillable = [
        'views',
        'ads_id',
    ];
}
