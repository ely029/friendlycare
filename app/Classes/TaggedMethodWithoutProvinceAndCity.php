<?php

declare(strict_types=1);

namespace App\Classes;

use App\Clinics;

class TaggedMethodWithoutProvinceAndCity
{
    public function index($obj, $method)
    {
        $clinics = new Clinics();
        if ($obj['province'][0] === '' && $obj['city'][0] === '' && $obj['philhealth_accredited'][0] === 1 && $obj['free_consultation'][0] === 1) {
            return $clinics->getTaggedMethodFirstScenario($method);
        }

        if ($obj['province'][0] === '' && $obj['city'][0] === '' && $obj['philhealth_accredited'][0] === 0 && $obj['free_consultation'][0] === 0) {
            return $clinics->getTaggedMethodSecondScenario($method);
        }

        if ($obj['province'][0] === '' && $obj['city'][0] === '' && $obj['philhealth_accredited'][0] === 1 && $obj['free_consultation'][0] === 0) {
            return $clinics->getTaggedMethodThirdScenario($method);
        }

        if ($obj['province'][0] === '' && $obj['city'][0] === '' && $obj['philhealth_accredited'][0] === 0 && $obj['free_consultation'][0] === 1) {
            return $clinics->getTaggedMethodFourthScenario($method);
        }
    }
}
