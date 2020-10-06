<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'family_planning_type_id',
    ];
}
