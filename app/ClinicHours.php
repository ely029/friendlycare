<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClinicHours extends Model
{
    protected $fillable = [
        'clinic_id',
        'day',
        'from',
        'to',
        'is_checked',
        'days',
        'froms',
        'tos',
    ];
}
