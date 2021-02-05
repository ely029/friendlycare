<?php

declare(strict_types=1);

namespace App\Classes;

use App\Clinics;

class SearchClinicWithProvinceAndCity
{
    public function searchClinic($obj)
    {
        $clinic = new Clinics();
        if ($obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 1) {
            return $clinic->getClinicFifthScenario();
        }
        if ($obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicSixthScenario();
        }
        if ($obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicSeventhScenario();
        }
        if ($obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 1) {
            return $clinic->getClinicEighthScenario();
        }
    }
}
