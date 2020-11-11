<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientTimeSlot extends Model
{
    protected $table = 'patient_time_slot';

    protected $fillable = [
        'clinic_id',
        'number',
    ];
}
