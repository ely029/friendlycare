<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Booking;
use App\EventsNotification;
use App\Http\Controllers\Controller;
use App\RatingDetails;
use App\Ratings;
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

    public function postRating(Request $request)
    {
        $obj = json_decode($request->getContent(), true);
        Ratings::create([
            'patient_id' => $obj['patient_id'][0],
            'clinic_id' => $obj['clinic_id'][0],
            'review' => $obj['review'][0],
        ]);

        $id = DB::table('ratings')->select('id')->where('patient_id', $obj['patient_id'][0])->where('clinic_id', $obj['clinic_id'][0])->pluck('id');
        EventsNotification::where(['patient_id' => $obj['patient_id'], 'status' => 4])->update([
            'is_rated' => 1,
        ]);
        Booking::where(['clinic_id' => $obj['clinic_id'][0], 'patient_id' => $obj['patient_id'][0]])->update([
            'is_rated' => 1,
        ]);
        for ($eee = 0; $eee <= 2; $eee++) {
            RatingDetails::create([
                'ratings' => $obj['ratings'][$eee],
                'rating_no' => $eee,
                'rating_id' => $id[0],
            ]);
        }

        return response([
            'name' => 'postRating',
            'message' => 'rate post successfully',
        ]);
    }

    public function rating()
    {
        $details = Ratings::all();

        return response([
            'name' => 'Rating',
            'details' => $details,
        ]);
    }

    public function ratingDetails()
    {
        $details = RatingDetails::all();

        return response([
            'name' => 'RatingDetails',
            'details' => $details,
        ]);
    }
}
