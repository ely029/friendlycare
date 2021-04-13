<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\MedicalHistory
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int|null $question_no
 * @property int|null $yes
 * @property int|null $no
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereQuestionNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereYes($value)
 * @mixin \Eloquent
 */
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
