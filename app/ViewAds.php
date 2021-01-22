<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewAds extends Model
{
    protected $table = 'ad_views';
    protected $fillable = [
        'views',
        'ads_id',
    ];
}
