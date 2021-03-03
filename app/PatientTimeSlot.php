<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PatientTimeSlot extends Model
{
    protected $table = 'patient_time_slot';

    protected $fillable = [
        'clinic_id',
        'number',
    ];

    public function getSlot($id)
    {
        return DB::table('patient_time_slot')->select('number_of_slots')->where('clinic_id', $id)->pluck('number_of_slots');
    }

    public function createTimeSlot($clinic, $obj)
    {
        PatientTimeSlot::create([
            'clinic_id' => $clinic[0],
            'number_of_slots' => $obj['timeslot'][0],
        ]);
    }
}
