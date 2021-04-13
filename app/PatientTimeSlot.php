<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\PatientTimeSlot
 *
 * @property int $id
 * @property int|null $number
 * @property int|null $clinic_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $number_of_slots
 * @method static \Illuminate\Database\Eloquent\Builder|PatientTimeSlot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientTimeSlot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientTimeSlot query()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientTimeSlot whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientTimeSlot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientTimeSlot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientTimeSlot whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientTimeSlot whereNumberOfSlots($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientTimeSlot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
