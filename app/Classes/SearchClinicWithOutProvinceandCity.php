<?php

declare(strict_types=1);

namespace App\Classes;

use App\Clinics;

class SearchClinicWithOutProvinceandCity
{
    public function searchClinic($obj)
    {
        $clinic = new Clinics();
        if ($obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 1) {
            return $clinic->getClinicFirstScenario($obj);
        }
        if ($obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicSecondScenario($obj);
        }
        if ($obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicThirdScenario($obj);
        }
        if ($obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 1) {
            return $clinic->getClinicFourthScenario($obj);
        }
    }
}
