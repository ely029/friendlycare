<?php

declare(strict_types=1);

namespace App\Classes;

use App\Clinics;

class SearchClinicWithProvinceAndCity
{
    public function searchClinic($obj, $service)
    {
        $clinic = new Clinics();
        if ($obj['province'][0] !== '' && $obj['city'][0] !== '' && $obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 1) {
            return $clinic->getClinicFifthScenario($obj, $service);
        }
        if ($obj['province'][0] !== '' && $obj['city'][0] !== '' && $obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicSixthScenario($obj, $service);
        }
        if ($obj['province'][0] !== '' && $obj['city'][0] !== '' && $obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicSeventhScenario($obj, $service);
        }
        if ($obj['province'][0] !== '' && $obj['city'][0] !== '' && $obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 1) {
            return $clinic->getClinicEighthScenario($obj, $service);
        }
    }
}
