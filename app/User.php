<?php

declare(strict_types=1);

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Storage;

/**
 * App\User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $middle_initial
 * @property string|null $password
 * @property string|null $birth_date
 * @property string|null $gender
 * @property string $email
 * @property string|null $age
 * @property string|null $city
 * @property string|null $municipality
 * @property string|null $province
 * @property string|null $contact_number
 * @property string|null $profession
 * @property string|null $training
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $role_id
 * @property string $photo_alt
 * @property string $photo_extension
 * @property string|null $fcm_notification_key
 * @property string|null $contact_number_1
 * @property string|null $professions
 * @property string|null $trainings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Clinics[] $clinics
 * @property-read int|null $clinics_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\FcmRegistrationToken[] $fcmRegistrationTokens
 * @property-read int|null $fcm_registration_tokens_count
 * @property-read mixed $photo_name
 * @property-read mixed $photo_path
 * @property-read mixed $photo_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Patients[] $patients
 * @property-read int|null $patients_count
 * @property-read \App\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Social[] $socials
 * @property-read int|null $socials_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Spouses[] $spouses
 * @property-read int|null $spouses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Staffs[] $staffs
 * @property-read int|null $staffs_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereContactNumber1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFcmNotificationKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMiddleInitial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMunicipality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhotoAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhotoExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfessions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTraining($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTrainings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    public const PATH_PREFIX = 'public/users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'municipality',
        'age',
        'province',
        'city',
        'birth_date',
        'gender',
        'fcm_notification_key',
        'first_name',
        'last_name',
        'middle_initial',
        'profession',
        'professions',
        'trainings',
        'contact_number_1',
    ];

    /*\
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Improves performance since hasAccess is always called in the middleware
    protected $with = ['role'];

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function clinics()
    {
        return $this->hasMany('App\Clinics', 'user_id');
    }

    public function staffs()
    {
        return $this->hasMany('App\Staffs', 'user_id');
    }

    public function spouses()
    {
        return $this->hasMany('App\Spouses', 'patient_id');
    }

    public function patients()
    {
        return $this->hasMany('App\Patients', 'user_id');
    }

    public function socials()
    {
        return $this->hasMany(Social::class);
    }

    public function hasAccess($route)
    {
        return $this->role->hasAccess($route);
    }

    public function getPhotoNameAttribute()
    {
        if ($this->id && $this->photo_extension) {
            return "{$this->id}.{$this->photo_extension}";
        }

        return null;
    }

    public function getPhotoPathAttribute()
    {
        $name = $this->getPhotoNameAttribute();

        return $name === null ? null : self::PATH_PREFIX . "/{$name}";
    }

    public function getPhotoUrlAttribute()
    {
        $path = $this->getPhotoPathAttribute();

        if (Storage::exists($path)) {
            return Storage::url($path) . '?t=' . Storage::lastModified($path);
        }

        return '/assets/dashboard/img/user_photo.jpg';
    }

    public function setPhotoExtensionAttribute($value)
    {
        $path = $this->getPhotoPathAttribute();

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $this->attributes['photo_extension'] = $value;
    }

    public function fcmRegistrationTokens()
    {
        return $this->hasMany(FcmRegistrationToken::class);
    }

    public function patientsLessNineteen($request)
    {
        if ($request['date-from'] === null && $request['date-to'] === null) {
            return DB::table('users')->leftJoin('patients', 'users.id', 'patients.user_id')
                ->distinct('users.name')
                ->select('users.id', 'users.name', 'users.email', 'users.age', 'patients.province', DB::raw('DATE_FORMAT(users.created_at, "%m/%d/%Y") as registered_at'), 'family_plan_type_subcategory.name as service_name')
                ->leftJoin('fpm_type_service', 'fpm_type_service.patient_id', 'users.id')
                ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                ->where('users.age', '<=', 19)
                ->get();
        }
        return DB::table('users')->leftJoin('patients', 'users.id', 'patients.user_id')
            ->distinct('users.name')
            ->select('users.id', 'users.name', 'users.email', 'users.age', 'patients.province', DB::raw('DATE_FORMAT(users.created_at, "%m/%d/%Y") as registered_at'), 'family_plan_type_subcategory.name as service_name')
            ->whereBetween('users.created_at', [$request['date-from'], $request['date-to']])
            ->leftJoin('fpm_type_service', 'fpm_type_service.patient_id', 'users.id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
            ->where('users.age', '<=', 19)
            ->get();
    }

    public function patientsMoreThanTwenty($request)
    {
        if ($request['date-from'] === null && $request['date-to'] === null) {
            return DB::table('users')->leftJoin('patients', 'users.id', 'patients.user_id')
                ->distinct('users.name')
                ->select('users.id', 'users.name', 'users.email', 'users.age', 'patients.province', DB::raw('DATE_FORMAT(users.created_at, "%m/%d/%Y") as registered_at'), 'family_plan_type_subcategory.name as service_name')
                ->leftJoin('fpm_type_service', 'fpm_type_service.patient_id', 'users.id')
                ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                ->where('users.age', '>=', 20)
                ->get();
        }
        return DB::table('users')->leftJoin('patients', 'users.id', 'patients.user_id')
            ->distinct('users.name')
            ->select('users.id', 'users.name', 'users.email', 'users.age', 'patients.province', DB::raw('DATE_FORMAT(users.created_at, "%m/%d/%Y") as registered_at'), 'family_plan_type_subcategory.name as service_name')
            ->leftJoin('fpm_type_service', 'fpm_type_service.patient_id', 'users.id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
            ->whereBetween('users.created_at', [$request['date-from'], $request['date-to']])
            ->where('users.age', '>=', 20)
            ->get();
    }

    public function getPatientManagementDetails()
    {
        return DB::table('users')
            ->leftJoin('patients', 'patients.user_id', 'users.id')
            ->distinct('users.name')
            ->leftJoin('fpm_type_service', 'fpm_type_service.patient_id', 'users.id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
            ->select('users.name', 'users.email', 'users.id', 'users.age', 'patients.province', 'patients.municipality', 'family_plan_type_subcategory.name as service_name', DB::raw('DATE_FORMAT(users.created_at, "%m/%d/%Y") as registered_at'), DB::raw('DATE_FORMAT(fpm_type_service.updated_at, "%m/%d/%Y") as date_last_update'), DB::raw('IF(fpm_type_service.service_id is null, "No", "Yes") as fpm_type_service'), DB::raw('
            (
                CASE 
                WHEN patients.fpm_user_type = 1 THEN "New Acceptor"
                WHEN patients.fpm_user_type = 2 THEN "Changing Methods"
                WHEN patients.fpm_user_type = 3 THEN "Curent User"
                WHEN patients.fpm_user_type = 4 THEN "Restart"
                END
            )AS fpm_2'), 'family_plan_type_subcategory.name as fpm_1')
            ->where('users.role_id', 3)
            ->get();
    }

    public function getStaff()
    {
        return DB::table('users')
            ->join('staffs', 'staffs.user_id', 'users.id')
            ->join('clinics', 'clinics.id', 'staffs.clinic_id')
            ->where('users.role_id', '<>', 1)
            ->where('users.role_id', '<>', 3)
            ->select('users.id', 'users.name', 'users.first_name', 'users.last_name', 'clinics.clinic_name', 'users.role_id', 'users.email');
    }

    public function getAdmin()
    {
        return DB::table('users')
            ->select('users.id', 'users.name', 'users.first_name', 'users.last_name', 'users.email_verified_at as clinic_name', 'users.role_id', 'users.email')
            ->where('users.role_id', '<>', 1)
            ->where('users.role_id', '<>', 3)
            ->where('users.role_id', '<>', 4);
    }

    public function getStaffFCMToken($id)
    {
        return DB::table('users')->select('users.fcm_notification_key')
            ->leftJoin('staffs', 'staffs.user_id', 'users.id')
            ->where('users.fcm_notification_key', '<>', null)
            ->where('staffs.clinic_id', $id)->get()->toArray();
    }

    public function resetIndexPageData($id)
    {
        return DB::table('users')
            ->leftJoin('staffs', 'staffs.user_id', 'users.id')
            ->leftJoin('clinics', 'clinics.id', 'staffs.clinic_id')
            ->select('users.email', 'users.id', 'clinics.clinic_name')
            ->where('users.id', $id)
            ->get();
    }
}
