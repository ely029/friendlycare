<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingTime extends Model
{
    protected $table = 'booking_time';
    protected $fillable = [
        'patient_id',
        'time_slot',
        'booking_id',
        'status',
    ];
}
