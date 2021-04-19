<?php

declare(strict_types=1);

namespace App\Classes;

use App\Clinics;

class SearchClinicWithProvinceAndCity
{
    public function searchClinic($obj)
    {
        $clinic = new Clinics();
        if ($obj['province'][0] !== '' && $obj['city'][0] !== '' && $obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 1) {
            return $clinic->getClinicFifthScenario($obj);
        }
        if ($obj['province'][0] !== '' && $obj['city'][0] !== '' && $obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicSixthScenario($obj);
        }
        if ($obj['province'][0] !== '' && $obj['city'][0] !== '' && $obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicSeventhScenario($obj);
        }
        if ($obj['province'][0] !== '' && $obj['city'][0] !== '' && $obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 1) {
            return $clinic->getClinicEighthScenario($obj);
        }
        if ($obj['province'][0] !== '' && $obj['city'][0] === '' && $obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicNinthScenario($obj);
        }
        if ($obj['province'][0] === '' && $obj['city'][0] !== '' && $obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 0) {
            return $clinic->getClinicTenthScenario($obj);
        }
    }
}
