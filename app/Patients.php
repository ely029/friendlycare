<?php

 declare(strict_types=1);

 namespace App;

 use Illuminate\Database\Eloquent\Model;

/**
 * App\Patients
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $civil_status
 * @property string|null $religion
 * @property string|null $occupation
 * @property string|null $monthly_income
 * @property int|null $no_of_living_children
 * @property int|null $family_plan_type_id
 * @property string|null $barangay
 * @property string|null $no
 * @property string|null $street
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $street_address
 * @property string|null $do_you_have_plan_children
 * @property string|null $city
 * @property string|null $province
 * @property string|null $municipality
 * @property string|null $citymunicipality
 * @property string|null $monthly_income_1
 * @property int|null $fpm_user_type
 * @property int|null $family_plan_reasons
 * @property int|null $miscarriage_1
 * @method static \Illuminate\Database\Eloquent\Builder|Patients newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patients newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patients query()
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereCitymunicipality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereCivilStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereDoYouHavePlanChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereFamilyPlanReasons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereFamilyPlanTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereFpmUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereMiscarriage1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereMonthlyIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereMonthlyIncome1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereMunicipality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereNoOfLivingChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereReligion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereStreetAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patients whereUserId($value)
 * @mixin \Eloquent
 */
class Patients extends Model
{
    protected $fillable = ['user_id', 'fpm_user_type', 'miscarriage_1', 'municipality'];
}
