<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\ClinicGallery
 *
 * @property int $id
 * @property int $clinic_id
 * @property string|null $file_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $file_url
 * @property int|null $value_id
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicGallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicGallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicGallery query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicGallery whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicGallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicGallery whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicGallery whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicGallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicGallery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClinicGallery whereValueId($value)
 * @mixin \Eloquent
 */
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

    public function createGallery($icon, $request, $icon_url)
    {
        ClinicGallery::create([
            'file_name' => $icon[0]->getClientOriginalName(),
            'clinic_id' => $request['clinic'],
            'file_url' => $icon_url,
        ]);
    }
}
