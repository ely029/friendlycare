<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventsNotification extends Model
{
    protected $table = 'events_notification';

    protected $fillable = [
        'title',
        'message',
        'type',
        'schedule',
        'date_string',
        'date',
        'time',
        'is_approve',
    ];
}
