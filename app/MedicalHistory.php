<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MedicalHistory extends Model
{
    protected $table = 'medical_history';
    protected $fillable = [
        'patient_id',
        'question_no',
        'yes',
        'no',
    ];

    public function patientManagementInformation($id)
    {
        return DB::table('medical_history')->select('question_no', 'yes', 'no')->where('patient_id', $id)->get();
    }
}
