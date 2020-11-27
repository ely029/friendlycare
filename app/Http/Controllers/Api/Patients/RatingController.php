<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function getRatingDetails($id)
    {
        $details = DB::table('booking')
            ->leftJoin('clinics', 'clinics.id', 'booking.clinic_id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->select('clinics.clinic_name', 'family_plan_type_subcategory.name as service_name')
            ->where('booking.id', $id)
            ->get();

        return response([
            'name' => 'getRatingDetails',
            'details' => $details,
        ]);
    }
}
