<?php

declare(strict_types=1);

namespace App\Classes;

use App\Clinics;

class TaggedMethodWithoutProvinceAndCity
{
    public function index($obj, $getMethod)
    {
        $clinics = new Clinics();
        if ($obj['philhealth_accredited'][0] === 1 && $obj['free_consultation'][0] === 1) {
            return $clinics->getTaggedMethodFirstScenario($getMethod);
        }

        if ($obj['philhealth_accredited'][0] === 0 && $obj['free_consultation'][0] === 0) {
            return $clinics->getTaggedMethodSecondScenario($getMethod);
        }

        if ($obj['philhealth_accredited'][0] === 1 && $obj['free_consultation'][0] === 0) {
            return $clinics->getTaggedMethodThirdScenario($getMethod);
        }

        if ($obj['philhealth_accredited'][0] === 0 && $obj['free_consultation'][0] === 1) {
            return $clinics->getTaggedMethodFourthScenario($getMethod);
        }
    }
}
