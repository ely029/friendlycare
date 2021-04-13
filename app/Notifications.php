<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Notifications
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications query()
 * @mixin \Eloquent
 */
class Notifications extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'patient_id',
        'message',
        'type',
        'event_id',
    ];
}
