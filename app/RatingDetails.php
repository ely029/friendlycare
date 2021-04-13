<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RatingDetails
 *
 * @property int $id
 * @property int|null $rating_id
 * @property string|null $ratings
 * @property int|null $rating_no
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RatingDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RatingDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RatingDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|RatingDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RatingDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RatingDetails whereRatingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RatingDetails whereRatingNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RatingDetails whereRatings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RatingDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RatingDetails extends Model
{
    protected $table = 'ratings_details';
    protected $fillable = [
        'rating_id',
        'rating_no',
        'ratings',
    ];
}
