<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Provider;

use App\Http\Controllers\Controller;
use App\Ratings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function getDetails($id)
    {
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $ratings = new Ratings();
        $details = $ratings->providerRatingDetails($getClinicId[0]);

        return response([
            'name' => 'RatingDetails',
            'details' => $details,
        ]);
    }
}
