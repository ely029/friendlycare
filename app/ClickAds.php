<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClickAds extends Model
{
    protected $table = 'ad_clicks';
    protected $fillable = [
        'clicks',
        'ads_id',
    ];
}
