<?php

declare(strict_types=1);

namespace App\Classes;

use App\Clinics;

class SearchClinicWithOutProvinceandCity
{
    public function searchClinic($obj, $service)
    {
        $clinic = new Clinics();
        if ($obj['province'][0] === '' && $obj['city'][0] === '' && $obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 1) {
            return $clinic->getClinicFirstScenario($service);
        }
        if ($obj['province'][0] === '' && $obj['city'][0] === '' && $obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicSecondScenario($service);
        }
        if ($obj['province'][0] === '' && $obj['city'][0] === '' && $obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicThirdScenario($service);
        }
        if ($obj['province'][0] === '' && $obj['city'][0] === '' && $obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 1) {
            return $clinic->getClinicFourthScenario($service);
        }
    }
}
