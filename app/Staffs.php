<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Staffs
 *
 * @property int $id
 * @property int|null $clinic_id
 * @property int|null $user_id
 * @property string|null $civil_status
 * @property string|null $religion
 * @property string|null $occupation
 * @property string|null $monthly_income
 * @property int|null $no_of_living_children
 * @property int|null $family_plan_type_id
 * @property string|null $barangay
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $profession
 * @property string|null $training
 * @property string|null $street_address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Clinics[] $clinics
 * @property-read int|null $clinics_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs query()
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereCivilStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereFamilyPlanTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereMonthlyIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereNoOfLivingChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereReligion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereStreetAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereTraining($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staffs whereUserId($value)
 * @mixin \Eloquent
 */
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
