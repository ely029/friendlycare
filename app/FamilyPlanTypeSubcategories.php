<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FamilyPlanTypeSubcategories extends Model
{
    protected $table = 'family_plan_type_subcategory';
    protected $fillable = [
        'family_plan_type_id',
        'short_name',
        'name',
        'typical_validity',
        'percent_effective',
        'icon',
        'icon_url',
    ];

    public function fpmPerPageHeader($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->select('name', 'short_name', 'icon_url', 'percent_effective', 'typical_validity', 'family_plan_type_id')
            ->where('id', $id)
            ->get();
    }

    public function fpmPerPageDescription($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->select('description_filipino', 'description_english', 'how_it_works_english', 'side_effect_english', 'additional_note_english', 'how_it_works_filipino', 'side_effect_filipino', 'additional_note_filipino')
            ->where('id', $id)
            ->get();
    }

    public function fpmPerPageVideoLink($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.video_link')
            ->where('family_plan_type_subcategory.id', $id)
            ->get();
    }

    public function fpmPerPageGallery($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('service_gallery', 'service_gallery.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.video_link', 'service_gallery.file_url')
            ->where('family_plan_type_subcategory.id', $id)
            ->get();
    }

    public function serviceGalleries()
    {
        return $this->hasMany('App\ServiceGallery', 'service_id');
    }

    public function getUncheckedServices($id)
    {
        return DB::table('family_plan_type_subcategory')->select('id')->whereNotIn('id', function ($query) use ($id) {
            $query->select('service_id')->from('clinic_service')->where('clinic_id', $id);
        })->get();
    }

    public function getUncheckedPaidServices($id)
    {
        return DB::table('family_plan_type_subcategory')->select('id')->whereNotIn('id', function ($query) use ($id) {
            $query->select('service_id')->from('paid_services')->where('clinic_id', $id);
        })->get();
    }

    public function getSelectedService($request)
    {
        return DB::table('family_plan_type_subcategory')->select('id', 'name')->where('id', $request['service_id'])->get();
    }

    public function selectMethodPageModern()
    {
        return DB::table('family_plan_type_subcategory')
            ->select('id', 'name', 'short_name', 'family_plan_type_id', 'percent_effective', 'icon_url')
            ->where('is_approve', 1)
            ->where('family_plan_type_id', 1)
            ->get();
    }

    public function selectMethodPagePermanent()
    {
        return DB::table('family_plan_type_subcategory')
            ->select('id', 'name', 'short_name', 'family_plan_type_id', 'percent_effective', 'icon_url')
            ->where('is_approve', 1)
            ->where('family_plan_type_id', 2)
            ->get();
    }

    public function selectMethodPageNatural()
    {
        return DB::table('family_plan_type_subcategory')
            ->select('id', 'name', 'short_name', 'family_plan_type_id', 'percent_effective', 'icon_url')
            ->where('is_approve', 1)
            ->where('family_plan_type_id', 3)
            ->get();
    }

    public function getFPMNaturalServicePage($getDetails)
    {
        return DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.id', 'name', 'short_name', 'type', 'percent_effective', 'icon_url')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->where('clinics.id', $getDetails[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->get();
    }

    public function getFPMPermanentServicePage($getDetails)
    {
        return DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.id', 'name', 'short_name', 'type', 'percent_effective', 'icon_url')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->where('clinics.id', $getDetails[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->get();
    }

    public function getFPMModernServicePage($getDetails)
    {
        return DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.id', 'name', 'short_name', 'type', 'percent_effective', 'icon_url')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->where('clinics.id', $getDetails[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->get();
    }

    public function providerInformationModern($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('clinic_service.is_checked', 1)
            ->get();
    }

    public function providerInformationPermanent($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('clinic_service.is_checked', 1)
            ->get();
    }

    public function providerInformationNatural($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('clinic_service.is_checked', 1)
            ->get();
    }

    public function updateFPM($requests, $request)
    {
        return FamilyPlanTypeSubcategories::where('id', $requests['id'])->update([
            'name' => $requests['name'],
            'family_plan_type_id' => $requests['family_plan_type_id'],
            'short_name' => $requests['short_name'],
            'typical_validity' => $requests['typical_validity'],
            'percent_effective' => $requests['percent_effective'],
            'description_english' => $requests['description_english'],
            'description_filipino' => $requests['description_tagalog'],
            'how_it_works_english' => $requests['how_it_works_english'],
            'how_it_works_filipino' => $requests['how_it_works_tagalog'],
            'side_effect_filipino' => $requests['side_effect_tagalog'],
            'side_effect_english' => $requests['side_effect_english'],
            'additional_note_english' => $requests['additional_note_english'],
            'additional_note_filipino' => $requests['additional_note_tagalog'],
            'video_link' => $requests['video_link'],
            'icon' => $request['icon_1'],
            'icon_url' => $request['icon_url'],
        ]);
    }
}
