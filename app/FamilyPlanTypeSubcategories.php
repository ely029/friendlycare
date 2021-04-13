<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\FamilyPlanTypeSubcategories
 *
 * @property int $id
 * @property int $family_plan_type_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $short_name
 * @property string|null $percent_effective
 * @property string|null $typical_validity
 * @property string|null $description_english
 * @property string|null $description_filipino
 * @property string|null $how_it_works_english
 * @property string|null $how_it_works_filipino
 * @property string|null $side_effect_english
 * @property string|null $side_effect_filipino
 * @property string|null $additional_note_english
 * @property string|null $additional_note_filipino
 * @property int|null $is_approve
 * @property string|null $video_link
 * @property string|null $icon
 * @property string|null $icon_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ServiceGallery[] $serviceGalleries
 * @property-read int|null $service_galleries_count
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereAdditionalNoteEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereAdditionalNoteFilipino($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereDescriptionEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereDescriptionFilipino($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereFamilyPlanTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereHowItWorksEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereHowItWorksFilipino($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereIconUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereIsApprove($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories wherePercentEffective($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereSideEffectEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereSideEffectFilipino($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereTypicalValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPlanTypeSubcategories whereVideoLink($value)
 * @mixin \Eloquent
 */
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
            ->distinct('name')
            ->select('id', 'name', 'short_name', 'family_plan_type_id', 'percent_effective', 'icon_url')
            ->where('is_approve', 1)
            ->where('family_plan_type_id', 1)
            ->get();
    }

    public function selectMethodPagePermanent()
    {
        return DB::table('family_plan_type_subcategory')
            ->distinct('name')
            ->select('id', 'name', 'short_name', 'family_plan_type_id', 'percent_effective', 'icon_url')
            ->where('is_approve', 1)
            ->where('family_plan_type_id', 2)
            ->get();
    }

    public function selectMethodPageNatural()
    {
        return DB::table('family_plan_type_subcategory')
            ->distinct('name')
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
            ->where('clinic_service.is_checked', 1)
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
            ->where('clinic_service.is_checked', 1)
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
            ->where('clinic_service.is_checked', 1)
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

    public function updateFPMWithIcon($requests, $request)
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
            'icon_url' => $request['pic_url'],
        ]);
    }
    public function updateFPMNoIcon($requests)
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
        ]);
    }

    public function getAllServicesModernMethod()
    {
        return DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id')
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('family_plan_type_subcategory.is_approve', 1)
            ->get();
    }

    public function getAllServicesPermanentMethod()
    {
        return DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id')
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('family_plan_type_subcategory.is_approve', 1)
            ->get();
    }

    public function getAllServicesNaturalMethod()
    {
        return DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id')
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('family_plan_type_subcategory.is_approve', 1)
            ->get();
    }

    public function getServicesModernMethod($users)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $users[0])
            ->where('clinic_service.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->get();
    }

    public function getServicesPermanentMethod($users)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $users[0])
            ->where('clinic_service.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->get();
    }

    public function getServicesNaturalMethod($users)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $users[0])
            ->where('clinic_service.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->get();
    }

    public function modernMethodWithoutClinic()
    {
        return DB::table('family_plan_type_subcategory')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('clinic_service.is_checked', null);
    }

    public function permanentMethodWithoutClinic()
    {
        return DB::table('family_plan_type_subcategory')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('clinic_service.is_checked', null);
    }

    public function naturalMethodWithoutClinic()
    {
        return DB::table('family_plan_type_subcategory')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('clinic_service.is_checked', null);
    }

    public function modernMethodUpdateService($users)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $users[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('clinic_service.is_checked', 1);
    }

    public function permanentMethodUpdateService($users)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $users[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('clinic_service.is_checked', 1);
    }

    public function naturalMethodUpdateService($users)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $users[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('clinic_service.is_checked', 1);
    }

    public function modernMethodGetPaidServices()
    {
        return DB::table('family_plan_type_subcategory')
            ->leftJoin('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'paid_services.is_checked')
            ->where('paid_services.is_checked', null);
    }

    public function checkedMethodsGetPaidServices($user)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'paid_services.is_checked')
            ->where('paid_services.is_checked', 1)
            ->where('paid_services.clinic_id', $user[0])
            ->get();
    }

    public function methodsUpdatePaidServices()
    {
        return DB::table('family_plan_type_subcategory')
            ->leftJoin('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'paid_services.is_checked')
            ->where('paid_services.is_checked', null);
    }

    public function checkedMethodsUpdatePaidServices($user)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'paid_services.is_checked')
            ->where('paid_services.is_checked', 1)
            ->where('paid_services.clinic_id', $user[0]);
    }

    public function fpmMethodsShowModernMethods()
    {
        return DB::table('family_plan_type_subcategory')
            ->leftJoin('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', DB::raw('null as is_checked'))
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('fpm_methods.is_checked', null);
    }

    public function fpmMethodsShowPermanentMethods()
    {
        return DB::table('family_plan_type_subcategory')
            ->leftJoin('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', DB::raw('null as is_checked'))
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('fpm_methods.is_checked', null);
    }

    public function fpmMethodsShowNaturalMethods()
    {
        return DB::table('family_plan_type_subcategory')
            ->leftJoin('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', DB::raw('null as is_checked'))
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('fpm_methods.is_checked', null);
    }

    public function fpmMethodsModernMethods($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'fpm_methods.is_checked')
            ->where('fpm_methods.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('fpm_methods.patient_id', $id);
    }

    public function fpmMethodsPermanentMethods($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'fpm_methods.is_checked')
            ->where('fpm_methods.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('fpm_methods.patient_id', $id);
    }

    public function fpmMethodsNaturalMethods($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'fpm_methods.is_checked')
            ->where('fpm_methods.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('fpm_methods.patient_id', $id);
    }

    public function servicesOne($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('clinic_service.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where(['clinics.id' => $id, 'clinics.is_approve' => 1])
            ->get();
    }

    public function servicesTwo($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('clinic_service.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where(['clinics.id' => $id, 'clinics.is_approve' => 1])
            ->get();
    }

    public function servicesThree($id)
    {
        return DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('clinic_service.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where(['clinics.id' => $id, 'clinics.is_approve' => 1])
            ->get();
    }

    public function getFPMDetailsModernMethod()
    {
        return DB::table('family_plan_type_subcategory')
            ->select('name', 'short_name', 'percent_effective', DB::raw("'Modern Method' as method_name"))
            ->where('family_plan_type_id', 1)
            ->where('is_approve', 1)
            ->get();
    }

    public function getFPMDetailsPermanentMethod()
    {
        return DB::table('family_plan_type_subcategory')
            ->select('name', 'short_name', 'percent_effective', DB::raw("'Modern Method' as method_name"))
            ->where('family_plan_type_id', 2)
            ->where('is_approve', 1)
            ->get();
    }

    public function getFPMDetailsNaturalMethod()
    {
        return DB::table('family_plan_type_subcategory')
            ->select('name', 'short_name', 'percent_effective', DB::raw("'Modern Method' as method_name"))
            ->where('family_plan_type_id', 3)
            ->where('is_approve', 1)
            ->get();
    }
}
