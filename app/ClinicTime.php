<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\ClinicTime
 *
 * @property int $id
 * @property int|null $clinic_id
 * @property string|null $time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $days
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicTime query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicTime whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicTime whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicTime whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicTime whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClinicTime extends Model
{
    protected $table = 'clinic_time';
    protected $fillable = [
        'clinic_id',
        'time',
        'days',
    ];

    public function createTimeDuration($clinicId, $days)
    {
        $array_of_time = [];
        $getStartTime = DB::table('clinic_hours')
            ->select('froms')
            ->where('days', 'like', '%'.$days.'%')
            ->where('clinic_id', $clinicId)
            ->pluck('froms');

        $getEndTime = DB::table('clinic_hours')
            ->select('tos')
            ->where('days', 'like', '%'.$days.'%')
            ->where('clinic_id', $clinicId)
            ->pluck('tos');

        $starttime = $getStartTime[0] === '' || $getStartTime[0] === null ? '00:00' : $getStartTime[0];  // your start time
            $endtime = $getEndTime[0] === '' || $getEndTime[0] === null ? '00:00' : $getEndTime[0];  // End time
            $duration = '30';  // split by 30 mins

            $start_time = strtotime($starttime); //change to strtotime
            $end_time = strtotime($endtime); //change to strtotime

            $add_mins = $duration * 60;

        while ($start_time <= $end_time) { // loop between time
            $array_of_time[] = date('h:i A', $start_time);
            $start_time += $add_mins; // to check endtie=me
        }
        $count = count($array_of_time) - 1;
        for ($eee = 0; $eee <= $count; $eee++) {
            ClinicTime::create([
                'clinic_id' => $clinicId,
                'days' => $days,
                'time' => $array_of_time[$eee],
            ]);
        }
    }

    public function checkTime($clinic_id, $day)
    {
        return DB::table('clinic_hours')->select('froms', 'tos')->where('clinic_id', $clinic_id)->where('days', $day)->first();
    }

    public function getTime($clinicId, $day)
    {
        return DB::table('clinic_time')->select('time')->distinct('time')->where('days', $day)->where('clinic_id', $clinicId)->get()->toArray();
    }
}
