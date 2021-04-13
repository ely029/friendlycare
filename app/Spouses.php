<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Spouses
 *
 * @property int $id
 * @property int|null $patient_id
 * @property string|null $spouse_first_name
 * @property string|null $spouse_last_name
 * @property string|null $spouse_middle_initial
 * @property string|null $spouse_occupation
 * @property string|null $spouse_birth_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Spouses newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Spouses newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Spouses query()
 * @method static \Illuminate\Database\Eloquent\Builder|Spouses whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spouses whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spouses wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spouses whereSpouseBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spouses whereSpouseFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spouses whereSpouseLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spouses whereSpouseMiddleInitial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spouses whereSpouseOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spouses whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
