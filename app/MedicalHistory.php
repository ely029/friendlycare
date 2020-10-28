<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $table = 'medical_history';
    protected $fillable = [
        'patient_id',
        'question_no',
        'yes',
        'no',
    ];
}
