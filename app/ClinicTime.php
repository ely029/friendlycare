<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClinicTime extends Model
{
    protected $table = 'clinic_time';
    protected $fillable = [
        'clinic_id',
        'time',
        'days',
    ];

    public function createTimeDuration($clinicId)
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $array_of_time = [];
        for ($hhh = 0; $hhh < 7; $hhh++) {
            $getStartTime = DB::table('clinic_hours')
                ->select('froms')
                ->where('days', 'like', '%'.$days[$hhh].'%')
                ->where('clinic_id', $clinicId)
                ->pluck('froms');

            $getEndTime = DB::table('clinic_hours')
                ->select('tos')
                ->where('days', 'like', '%'.$days[$hhh].'%')
                ->where('clinic_id', $clinicId)
                ->pluck('tos');

            $starttime = $getStartTime[0];  // your start time
            $endtime = $getEndTime[0];  // End time
            $duration = '30';  // split by 30 mins

            $start_time = strtotime($starttime); //change to strtotime
            $end_time = strtotime($endtime); //change to strtotime

            $add_mins = $duration * 60;

            while ($start_time <= $end_time) { // loop between time
                $array_of_time[] = date('h:i A', $start_time);
                $start_time += $add_mins; // to check endtie=me
            }
        }
        return $array_of_time;
    }

    public function createTime($day, $clinicId)
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $count = count($day);
        for ($fff = 0; $fff <= $count; $fff++) {
            if (isset($day[$fff])) {
                $this->createClinicTime($clinicId, $days, $day, $fff);
            }
        }

        return 0;
    }

    public function getTime($clinicId, $day)
    {
        return DB::table('clinic_time')->select('time')->where('days', $day)->where('clinic_id', $clinicId)->get();
    }

    private function createClinicTime($clinicId, $days, $day, $fff)
    {
        for ($eee = 0; $eee < 7; $eee++) {
            ClinicTime::create([
                'clinic_id' => $clinicId,
                'days' => $days[$eee],
                'time' => $day[$fff],
            ]);
        }
    }
}
