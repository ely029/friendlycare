<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ClickAds
 *
 * @property int $id
 * @property string $clicks
 * @property int|null $ads_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ClickAds newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClickAds newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClickAds query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClickAds whereAdsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClickAds whereClicks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClickAds whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClickAds whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClickAds whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClickAds extends Model
{
    protected $table = 'ad_clicks';
    protected $fillable = [
        'clicks',
        'ads_id',
    ];
}
