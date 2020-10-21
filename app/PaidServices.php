<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaidServices extends Model
{
    protected $table = 'paid_services';
    protected $fillable = [
        'service_id',
        'clinic_id',
        'is_checked',
    ];
}
