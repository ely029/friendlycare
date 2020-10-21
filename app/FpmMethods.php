<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class FpmMethods extends Model
{
    protected $table = 'fpm_methods';
    protected $fillable = [
        'service_id',
        'patient_id',
        'is_checked',
    ];
}
