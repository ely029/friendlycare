<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingDetails extends Model
{
    protected $table = 'ratings_details';
    protected $fillable = [
        'rating_id',
        'rating_no',
        'ratings',
    ];
}
