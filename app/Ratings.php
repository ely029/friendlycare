<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    protected $table = 'ratings';
    protected $fillable = [
        'patient_id',
        'clinic_id',
        'review',
    ];
}
