<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalHistoryAnswer extends Model
{
    protected $table = 'medical_history_answer';
    protected $fillable = [
        'patient_id',
        'question_id',
        'answer',
        'value_id',
        'string_answer',
    ];
}
