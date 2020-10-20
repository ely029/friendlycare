<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClinicGallery extends Model
{
    protected $table = 'clinic_gallery';
    protected $fillable = [
        'clinic_id',
        'file_name',
        'file_url',
    ];
}
