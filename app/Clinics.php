<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinics extends Model
{
    protected $fillable = [
        'user_id',
        'clinic_name',
        'contact_number',
        'location',
        'is_close',
        'close_message',
        'description',
        'profile_photo',
        'type',
        'profession',
        'training',
        'street_address',
        'city',
        'municipality',
        'province',
        'email',
        'photo_url',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function staff()
    {
        return $this->belongsTo('App\Staffs');
    }
}
