<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staffs extends Model
{
    protected $fillable = [
        'clinic_id',
        'user_id',
    ];

    public function clinics()
    {
        return $this->hasMany('App\Clinics', 'user_id');
    }

    public function users()
    {
        return $this->hasMany('App\User', 'id');
    }
}
