<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class FpmTypeService extends Model
{
    protected $table = 'fpm_type_service';
    protected $fillable = [
        'patient_id',
        'service_id',
        'is_checked',
    ];
}
