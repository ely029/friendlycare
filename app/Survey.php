<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'survey';

    protected $fillable = [
        'date_from_datestring',
        'date_to_datestring',
        'time',
        'title',
        'message',
        'link',
        'date_from',
        'date_to',
        'is_open',
    ];
}
