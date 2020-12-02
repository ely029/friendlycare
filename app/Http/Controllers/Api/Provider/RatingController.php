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

    public function getRatingAverage($id)
    {
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $details = DB::table('ratings')
            ->join('ratings_details', 'ratings_details.rating_id', 'ratings.id')
            ->where('ratings.clinic_id', $getClinicId[0])
            ->avg('ratings_details.ratings');

        return response([
            'name' => 'AverageRatingsPerProvider',
            'details' => $details,
        ]);
    }

    public function filter(Request $request, $id)
    {
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $obj = json_decode($request->getContent(), true);

        $details = DB::table('ratings')
            ->join('users', 'users.id', 'ratings.patient_id')
            ->join('ratings_details', 'ratings_details.rating_id', 'ratings.id')
            ->select('users.name', 'ratings.review', 'ratings_details.ratings')
            ->whereMonth('ratings.created_at', '=', $obj['month'][0])
            ->where('ratings.clinic_id', $getClinicId[0])
            ->get();

        return response([
            'name' => 'ProviderRatingFilter',
            'details' => $details,
        ]);
    }
}
