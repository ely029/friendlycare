<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyPlanType extends Model
{
    protected $fillable = [
        'name',
    ];
}
