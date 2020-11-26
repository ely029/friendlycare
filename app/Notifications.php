<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

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
