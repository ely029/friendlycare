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
}
