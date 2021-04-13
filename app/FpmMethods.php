<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FpmMethods
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int|null $service_id
 * @property int|null $is_checked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FpmMethods newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FpmMethods newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FpmMethods query()
 * @method static \Illuminate\Database\Eloquent\Builder|FpmMethods whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FpmMethods whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FpmMethods whereIsChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FpmMethods wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FpmMethods whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FpmMethods whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FpmMethods extends Model
{
    protected $table = 'fpm_methods';
    protected $fillable = [
        'service_id',
        'patient_id',
        'is_checked',
    ];
}
