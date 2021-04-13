<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FamilyPlanType
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanType query()
 * @mixin \Eloquent
 */
class FamilyPlanType extends Model
{
    protected $fillable = [
        'name',
    ];
}
