<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdsManagement extends Model
{
    protected $table = 'ads_management';

    protected $fillable = [
        'company_name',
        'title',
        'ad_link',
        'image_url',
        'start_date',
        'end_date',
        'clicks',
        'view',
        'end_date_string',
        'start_date_string',
    ];
}
