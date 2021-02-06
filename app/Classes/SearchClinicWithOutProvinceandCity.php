<?php

declare(strict_types=1);

namespace App\Classes;

use App\Clinics;

class SearchClinicWithOutProvinceandCity
{
    public function searchClinic($obj)
    {
        $clinic = new Clinics();
        if ($obj['province'][0] === '' && $obj['city'][0] === '' && $obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 1) {
            return $clinic->getClinicFirstScenario();
        }
        if ($obj['province'][0] === '' && $obj['city'][0] === '' && $obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicSecondScenario();
        }
        if ($obj['province'][0] === '' && $obj['city'][0] === '' && $obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicThirdScenario();
        }
        if ($obj['province'][0] === '' && $obj['city'][0] === '' && $obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 1) {
            return $clinic->getClinicFourthScenario();
        }
    }
}
