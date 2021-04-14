<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\MedicalHistoryAnswer
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int|null $question_id
 * @property int|null $value_id
 * @property string|null $answer
 * @property string|null $string_answer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $string_answer_1
 * @property string|null $answer_1
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistoryAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistoryAnswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistoryAnswer query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistoryAnswer whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistoryAnswer whereAnswer1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistoryAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistoryAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistoryAnswer wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistoryAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistoryAnswer whereStringAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistoryAnswer whereStringAnswer1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistoryAnswer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistoryAnswer whereValueId($value)
 * @mixin \Eloquent
 */
class MedicalHistoryAnswer extends Model
{
    protected $table = 'medical_history_answer';
    protected $fillable = [
        'patient_id',
        'question_id',
        'answer',
        'value_id',
        'string_answer',
        'string_answer_1',
        'answer_1',
    ];

    public function index($id)
    {
        return DB::table('medical_history_answer')
            ->select('updated_at')
            ->limit(1)
            ->where('patient_id', $id)
            ->get();
    }
}
