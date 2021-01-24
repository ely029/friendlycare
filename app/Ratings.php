<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ratings extends Model
{
    protected $table = 'ratings';
    protected $fillable = [
        'patient_id',
        'clinic_id',
        'review',
    ];

    public function providerRatingDetails($id)
    {
        return DB::table('ratings_details')
            ->leftJoin('ratings', 'ratings.id', 'ratings_details.rating_id')
            ->leftJoin('users', 'ratings.patient_id', 'users.id')
            ->select('ratings.review', 'ratings_details.ratings', 'users.name', DB::raw('DATE_FORMAT(ratings_details.created_at, "%m/%d/%Y") as created_at'))
            ->where('ratings.clinic_id', $id)
            ->get();
    }
}
