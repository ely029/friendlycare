<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\ClinicHours
 *
 * @property int $id
 * @property int|null $clinic_id
 * @property string|null $day
 * @property string|null $from
 * @property string|null $to
 * @property int|null $is_checked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $days
 * @property string|null $froms
 * @property string|null $tos
 * @property string|null $id_value
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours whereFroms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours whereIdValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours whereIsChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours whereTos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicHours whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClinicHours extends Model
{
    protected $fillable = [
        'clinic_id',
        'day',
        'from',
        'to',
        'is_checked',
        'days',
        'froms',
        'tos',
        'id_value',
    ];

    public function providerInformationPage($id)
    {
        return DB::table('clinics')
            ->join('clinic_hours', 'clinic_hours.clinic_id', 'clinics.id')
            ->select('clinic_hours.days', 'clinic_hours.froms', 'clinic_hours.tos')
            ->where('clinic_hours.clinic_id', $id)
            ->get();
    }

    public function editPage($id)
    {
        return DB::table('clinic_hours')
            ->select('is_checked', 'days', 'froms', 'tos', 'id_value', 'id')
            ->where('clinic_id', $id)
            ->get();
    }

    public function createUncheckedClinicHours($request, $clinic_hours, $days)
    {
        return ClinicHours::create([
            'clinic_id' => $request['clinic_id'],
            'id_value' => $clinic_hours,
            'days' => $days['days'][$clinic_hours],
            'froms' => null,
            'tos' => null,
            'is_checked' => 0,
        ]);
    }

    public function createCheckedClinicHours($request, $clinic_hours)
    {
        return ClinicHours::create([
            'clinic_id' => $request['clinic_id'],
            'id_value' => $clinic_hours,
            'days' => $request['days'][$clinic_hours],
            'froms' => $request['from'][$clinic_hours],
            'tos' => $request['to'][$clinic_hours],
            'is_checked' => 1,
        ]);
    }

    public function createClinicHourWithCheckUpdate($request, $clinic_hours)
    {
        return ClinicHours::create([
            'clinic_id' => session('id'),
            'id_value' => $clinic_hours,
            'days' => $request['days'][$clinic_hours],
            'froms' => $request['from'][$clinic_hours],
            'tos' => $request['to'][$clinic_hours],
            'is_checked' => 1,
        ]);
    }

    public function createClinicHourWithoutCheck($request, $clinic_hours)
    {
        ClinicHours::create([
            'clinic_id' => session('id'),
            'id_value' => $clinic_hours,
            'days' => $request['days'][$clinic_hours],
            'froms' => null,
            'tos' => null,
            'is_checked' => 0,
        ]);
    }

    public function createClinicHourswithoutTime($request, $clinic_hours)
    {
        ClinicHours::create([
            'clinic_id' => $request['clinic_id'],
            'id_value' => $clinic_hours,
            'days' => $request['days'][$clinic_hours],
            'froms' => null,
            'tos' => null,
            'is_checked' => 0,
        ]);
    }

    public function createEmptyClinicHours($clinic_hours, $days)
    {
        ClinicHours::create([
            'clinic_id' => session('id'),
            'id_value' => $clinic_hours,
            'days' => $days['days'][$clinic_hours],
            'froms' => null,
            'tos' => null,
            'is_checked' => 0,
        ]);
    }
}
