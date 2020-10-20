<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClinicService extends Model
{
    protected $table = 'clinic_service';
    protected $fillable = [
        'clinic_id',
        'service_id',
        'is_checked',
    ];
}
