<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Holiday
 *
 * @property int $id
 * @property string|null $holiday_title
 * @property string|null $date
 * @property int|null $clinic_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $is_saved
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday query()
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereHolidayTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereIsSaved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Holiday extends Model
{
    protected $table = 'holiday';

    protected $fillable = [
        'clinic_id',
        'date',
        'holiday_title',
    ];

    public function getHolidayDetails($id)
    {
        $data = Holiday::where('clinic_id', $id);
        return response([$data]);
    }

    public function createHoliday($getClinicId, $obj)
    {
        Holiday::create([
            'clinic_id' => $getClinicId[0],
            'date' => $obj['date'][0],
            'holiday_title' => $obj['holiday_title'][0],
        ]);
    }
}
