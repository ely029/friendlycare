<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicPages extends Model
{
    protected $table = 'basic_pages';
    protected $fillable = [
        'content_name',
        'content',

    ];
}
