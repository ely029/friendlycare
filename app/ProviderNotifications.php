<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderNotifications extends Model
{
    protected $table = 'provider_notifications';
    protected $fillable = [
        'clinic_id',
        'type',
        'message',
        'title',
        'booking_id',
        'status',
    ];
}
