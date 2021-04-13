<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Ratings
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int|null $clinic_id
 * @property string|null $review
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Ratings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ratings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ratings query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ratings whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ratings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ratings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ratings wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ratings whereReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ratings whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    public function getRatingsProviderInformation($id)
    {
        return DB::table('ratings')
            ->join('ratings_details', 'ratings_details.rating_id', 'ratings.id')
            ->where('ratings.clinic_id', $id)
            ->avg('ratings_details.ratings');
    }

    public function countPatientRatings($id)
    {
        return DB::table('ratings')
            ->select('patient_id')
            ->where('clinic_id', $id)
            ->count();
    }

    public function viewPageCountRatings($id)
    {
        return DB::table('ratings')
            ->select('patient_id')
            ->where('clinic_id', $id)
            ->count();
    }

    public function viewPageDetails($id)
    {
        return DB::table('ratings')
            ->leftJoin('users', 'users.id', 'ratings.patient_id')
            ->leftJoin('ratings_details', 'ratings_details.rating_id', 'ratings.id')
            ->select('ratings_details.id', DB::raw('REPLACE(users.name,SUBSTR(users.name,2,2),"*****") as dddd '), 'ratings_details.ratings', 'ratings.review')
            ->where('ratings.clinic_id', $id)
            ->get();
    }
}
