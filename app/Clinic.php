<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
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
      'type'
    ];
}
