<?php

declare(strict_types=1);

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class TaggedMethodWithProvinceAndCity
{
    public function index($obj, $getMethod)
    {
        if ($obj['province'][0] !== '' && $obj['city'][0] !== '' && $obj['philhealth_accredited'][0] === 1 && $obj['free_consultation'][0] === 1) {
            return DB::table('clinics')
                ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
                ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
                ->where('clinic_service.service_id', $getMethod[0])
                ->Where('clinics.province', $obj['province'][0])
                ->Where('clinics.city', $obj['city'][0])
                ->Where('clinics.paid_service', 1)
                ->where('clinics.philhealth_accredited_1', 1)
                ->where('clinics.user_id', 0)
                ->get();
        }

        if ($obj['province'][0] !== '' && $obj['city'][0] !== '' && $obj['philhealth_accredited'][0] === 0 && $obj['free_consultation'][0] === 0) {
            return DB::table('clinics')
                ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
                ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
                ->where('clinic_service.service_id', $getMethod[0])
                ->Where('clinics.province', $obj['province'][0])
                ->Where('clinics.city', $obj['city'][0])
                ->where('clinics.user_id', 0)
                ->get();
        }

        if ($obj['province'][0] !== '' && $obj['city'][0] !== '' && $obj['philhealth_accredited'][0] === 1 && $obj['free_consultation'][0] === 0) {
            return DB::table('clinics')
                ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
                ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
                ->where('clinic_service.service_id', $getMethod[0])
                ->Where('clinics.province', $obj['province'][0])
                ->Where('clinics.city', $obj['city'][0])
                ->where('clinics.philhealth_accredited_1', 1)
                ->where('clinics.user_id', 0)
                ->get();
        }

        if ($obj['province'][0] !== '' && $obj['city'][0] !== '' && $obj['philhealth_accredited'][0] === 0 && $obj['free_consultation'][0] === 1) {
            return DB::table('clinics')
                ->leftJoin('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
                ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation', 'clinics.paid_service')
                ->where('clinic_service.service_id', $getMethod[0])
                ->where('clinics.province', $obj['province'][0])
                ->where('clinics.city', $obj['city'][0])
                ->Where('clinics.paid_service', 1)
                ->where('clinics.user_id', 0)
                ->get();
        }
    }
}
