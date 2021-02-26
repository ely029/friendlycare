<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
            ->select('is_checked', 'days', 'froms', 'tos', 'id_value')
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
}
