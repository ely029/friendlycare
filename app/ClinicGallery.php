<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClinicGallery extends Model
{
    protected $table = 'clinic_gallery';
    protected $fillable = [
        'clinic_id',
        'file_name',
        'file_url',
        'value_id',
    ];

    public function galleryEditProviderInformation($id)
    {
        return DB::table('clinic_gallery')
            ->join('clinics', 'clinics.id', 'clinic_gallery.clinic_id')
            ->select('clinic_gallery.file_name')
            ->where('clinic_gallery.clinic_id', $id)
            ->get();
    }

    public function editPage($id)
    {
        return DB::table('clinic_gallery')
            ->join('clinics', 'clinics.id', 'clinic_gallery.clinic_id')
            ->select('clinic_gallery.file_name', 'clinics.id as clinic_id', 'clinic_gallery.file_url', 'clinic_gallery.id')
            ->where('clinic_gallery.clinic_id', $id)
            ->get();
    }
}
