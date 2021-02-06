<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Spouses extends Model
{
    protected $fillable = [
        'patient_id',
        'spouse_first_name',
        'spouse_last_name',
        'spouse_middle_initial',
        'spouse_occupation',
        'spouse_birth_date',
    ];

    public function patientManagementInformation($id)
    {
        return DB::table('spouses')->select('spouse_first_name', 'spouse_last_name', 'spouse_birth_date', 'spouse_occupation')->where('patient_id', $id)->get();
    }
}
