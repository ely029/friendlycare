<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Booking;
use App\Clinics;
use App\EventsNotification;
use App\FamilyPlanTypeSubcategories;
use App\FpmMethods;
use App\Http\Clients\FcmClient;
use App\Http\Controllers\Api\Users\FcmRegistrationTokensController;
use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\MedicalHistory;
use App\MedicalHistoryAnswer;
use App\Patients;
use App\ProviderNotifications;
use App\Spouses;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class DefaultController extends Controller
{
    public function login(Request $request)
    {
        $obj = json_decode($request->getContent(), true);
        $fcm = new FcmRegistrationTokensController();
        $fcm1 = new FcmClient();
        if (\Auth::attempt(['email' => $obj['email'], 'password' => $obj['password'], 'role_id' => 3])) {
            $user1 = \Auth::user();
            $user = User::where('id', $user1['id'])->first();
            $fcm->store($obj, $fcm1, $user);
            return response([
                'login_success' => 'Login Successful',
                'id' => $user1['id'],
            ]);
        }
        return response([
            'errorCode' => '',
            'message' => 'Uh Oh! Your email/password isn\'t right. Please check and retry',
            'httpCode' => 422,
        ], 422);
    }

    public function verification()
    {
        $request = request()->all();
        $id = DB::table('users')->select('id')->where('email', $request['email'])->pluck('id');
        $name = DB::table('users')->select('name')->where('email', $request['email'])->pluck('name');
        Mail::send('email.patient.account-verification', ['id' => $id[0], 'name' => $name[0]], function ($mail) use ($request) {
            $mail->from('security@friendlycare.com');
            $mail->to($request['email'], 'Patient')->subject('Account Verification!');
        });

        return response([
            'errorCode' => '',
            'message' => 'Email Successfully sent',
            'httpCode' => 200,
        ], 200);
    }

    public function resetPassword()
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'email' => 'required',
            'confirm_email' => 'required|same:email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $users = DB::table('users')->select('id')->where('email', $request['email'])->pluck('id');

        Mail::send('email.patient.account-reset', ['users' => $users[0]], function ($mail) use ($request) {
            $mail->from('no-reply@friendlycare.com');
            $mail->to($request['email'], 'Patient')->subject('Reset Password');
        });

        return response([
            'message' => 'Email Successfully sent',
        ], 200);
    }

    public function register()
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'middle_initial' => 'required|max:2',
            'gender' => 'required|max:2',
            'password' => 'required|min:8',
            'birth_date' => 'required',
            'contact_number' => 'required|min:8|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($this->age($request['birth_date']) < 9) {
            return response()->json('Your age are not able to register.', 422);
        }
        $request['age'] = $this->age($request['birth_date']);
        $request['password'] = bcrypt($request['password']);
        $request['role_id'] = 3;
        $request['name'] = $request['first_name'] . ' ' . $request['last_name'];
        $request['contact_number_1'] = $request['contact_number'];
        $user = User::create($request);

        $request['user_id'] = $user->id;
        $request['patient_id'] = $user->id;
        $request['fpm_user_type'] = 1;

        Patients::create($request);
        Spouses::create($request);

        return response()->json('Congratulations! You are registered.', 200);
    }

    public function getAllUsers()
    {
        $users = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->join('spouses', 'spouses.patient_id', '=', 'users.id')
            ->select('patients.civil_status',
        'users.first_name',
        'users.last_name',
        'users.id',
        'users.middle_initial',
        'users.birth_date',
        'users.gender',
        'users.email',
        'users.age',
        'users.fcm_notification_key',
        'patients.city',
        'patients.citymunicipality',
        'patients.province',
        'users.contact_number_1 as contact_number',
        'patients.religion',
        'patients.occupation',
        'patients.street_address',
        'patients.monthly_income_1',
        'patients.no_of_living_children',
        'patients.family_plan_type_id',
        'patients.barangay',
        'spouses.spouse_first_name',
        'spouses.spouse_last_name',
        'spouses.spouse_middle_initial',
        'spouses.spouse_occupation',
        'spouses.spouse_birth_date',
        'patients.do_you_have_plan_children',
        'users.created_at',
        'users.updated_at',
         )
            ->get();
        return response()->json($users, 200);
    }

    public function getUserById($id)
    {
        $users = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->join('spouses', 'spouses.patient_id', '=', 'users.id')
            ->select('patients.civil_status',
        'users.first_name',
        'users.last_name',
        'users.id',
        'users.middle_initial',
        'users.birth_date',
        'users.gender',
        'users.email',
        'users.age',
        'patients.city',
        'users.fcm_notification_key',
        'patients.citymunicipality',
        'patients.province',
        'users.contact_number_1 as contact_number',
        'patients.religion',
        'patients.occupation',
        'patients.street_address',
        'patients.miscarriage_1 as miscarriage',
        'patients.monthly_income_1',
        'patients.no_of_living_children',
        'patients.family_plan_type_id',
        'patients.barangay',
        'spouses.spouse_first_name',
        'spouses.spouse_last_name',
        'spouses.spouse_middle_initial',
        'spouses.spouse_occupation',
        'spouses.spouse_birth_date',
        'patients.do_you_have_plan_children',
        'users.created_at',
        'users.updated_at',
         )
            ->where('users.id', $id)
            ->get();
        return response()->json($users, 200);
    }

    public function update()
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required',
            'middle_initial' => 'required|max:2',
            'gender' => 'required|max:2',
            'birth_date' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'contact_number' => 'required|min:8|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        User::find($request['id'])->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'middle_initial' => $request['middle_initial'],
            'gender' => $request['gender'],
            'birth_date' => $request['birth_date'],
            'email' => $request['email'],
            'age' => $this->age($request['birth_date']),
            'contact_number_1' => $request['contact_number'],
        ]);
        Patients::where('user_id', $request['id'])->update([
            'religion' => $request['religion'],
            'monthly_income_1' => $request['monthly_income'],
            'no_of_living_children' => $request['no_living_children'],
            'do_you_have_plan_children' => $request['do_you_have_plan_children'],
            'street_address' => $request['street_address'],
            'civil_status' => $request['civil_status'],
            'barangay' => $request['barangay'],
            'occupation' => $request['occupation'],
            'province' => $request['province'],
            'citymunicipality' => $request['citymunicipality'],
            'miscarriage_1' => $request['miscarriage'] ?? null,
        ]);
        Spouses::where('patient_id', $request['id'])->update([
            'spouse_first_name' => $request['spouse_first_name'],
            'spouse_last_name' => $request['spouse_last_name'],
            'spouse_middle_initial' => $request['spouse_middle_initial'],
            'spouse_occupation' => $request['spouse_occupation'],
            'spouse_birth_date' => $request['spouse_birth_date'],
        ]);
        $users = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->join('spouses', 'spouses.patient_id', '=', 'users.id')
            ->select('patients.civil_status',
        'users.first_name',
        'users.id',
        'users.last_name',
        'users.middle_initial',
        'users.birth_date',
        'users.gender',
        'users.email',
        'users.age',
        'patients.citymunicipality',
        'patients.province',
        'patients.miscarriage_1 as miscarriage',
        'users.contact_number_1 as contact_number',
        'patients.religion',
        'patients.occupation',
        'patients.street_address',
        'patients.monthly_income_1',
        'patients.no_of_living_children',
        'patients.family_plan_type_id',
        'patients.barangay',
        'spouses.spouse_first_name',
        'spouses.spouse_last_name',
        'spouses.spouse_middle_initial',
        'spouses.spouse_occupation',
        'spouses.spouse_birth_date',
        'patients.do_you_have_plan_children',
        'users.created_at',
        'users.updated_at',
         )
            ->where('users.id', $request['id'])
            ->get();

        return response()->json($users, 200);
    }

    public function getFpmMethodsShow($id)
    {
        $fpm = new FamilyPlanTypeSubcategories();
        $modernMethods = $fpm->fpmMethodsShowModernMethods();
        $permanentMethods = $fpm->fpmMethodsShowPermanentMethods();
        $naturalMethods = $fpm->fpmMethodsShowNaturalMethods();
        $modernMethodsFpmMethods = $fpm->fpmMethodsModernMethods($id);
        $permanentMethodsFpmMethods = $fpm->fpmMethodsPermanentMethods($id);
        $naturalMethodsFpmMethods = $fpm->fpmMethodsNaturalMethods($id);
        $modern = $modernMethods->union($modernMethodsFpmMethods)->get();
        $permanent = $permanentMethods->union($permanentMethodsFpmMethods)->get();
        $natural = $naturalMethods->union($naturalMethodsFpmMethods)->get();

        return response([
            'name' => 'FpmMethod',
            'modernMethod' => $modern,
            'permanentMethod' => $permanent,
            'natural' => $natural,
        ], 200);
    }

    public function createFpmShow($id)
    {
        $fpm = new FamilyPlanTypeSubcategories();
        $request = request()->all();
        for ($eee = 1;$eee <= 10000;$eee++) {
            if (isset($request['service_id_'.$eee])) {
                $request['service_id'] = $request['service_id_'.$eee];
                FpmMethods::create([
                    'service_id' => $request['service_id'],
                    'patient_id' => $id,
                    'is_checked' => 1,
                ]);
            }
        }

        $modernMethods = $fpm->fpmMethodsShowModernMethods();
        $permanentMethods = $fpm->fpmMethodsShowPermanentMethods();
        $naturalMethods = $fpm->fpmMethodsShowNaturalMethods();
        $modernMethodsFpmMethods = $fpm->fpmMethodsModernMethods($id);
        $permanentMethodsFpmMethods = $fpm->fpmMethodsPermanentMethods($id);
        $naturalMethodsFpmMethods = $fpm->fpmMethodsNaturalMethods($id);

        $modern = $modernMethods->union($modernMethodsFpmMethods)->get();
        $permanent = $permanentMethods->union($permanentMethodsFpmMethods)->get();
        $natural = $naturalMethods->union($naturalMethodsFpmMethods)->get();

        return response([
            'name' => 'FpmMethod',
            'modernMethod' => $modern,
            'permanentMethod' => $permanent,
            'natural' => $natural,
        ], 200);
    }

    public function getFPMDetails()
    {
        $fpm = new FamilyPlanTypeSubcategories();
        $modernMethod = $fpm->getFPMDetailsModernMethod();
        $permanentMethod = $fpm->getFPMDetailsPermanentMethod();
        $naturalMethod = $fpm->getFPMDetailsNaturalMethod();

        return response([
            'name' => 'FPMPage',
            'modernMethod' => $modernMethod,
            'permanentMethod' => $permanentMethod,
            'naturalMethod' => $naturalMethod,
        ]);
    }

    public function fpmPagePerMethod($id)
    {
        $header = DB::table('family_plan_type_subcategory')
            ->select('name', 'short_name', 'percent_effective', 'typical_validity', 'family_plan_type_id')
            ->where('id', $id)
            ->get();

        $description = DB::table('family_plan_type_subcategory')
            ->select('description_filipino', 'how_it_works_filipino', 'side_effect_filipino', 'additional_note_filipino')
            ->where('id', $id)
            ->get();

        $videolink = DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.video_link')
            ->where('family_plan_type_subcategory.id', $id)
            ->get();

        $gallery = DB::table('family_plan_type_subcategory')
            ->join('service_gallery', 'service_gallery.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.video_link', 'service_gallery.file_url')
            ->where('family_plan_type_subcategory.id', $id)
            ->get();

        $clinic = [];

        return response([
            'name' => 'fpmDetailsPerMethod',
            'headers' => $header,
            'videolink' => $videolink,
            'description' => $description,
            'gallery' => $gallery,
            'clinic' => $clinic,
        ]);
    }

    public function search(Request $request)
    {
        $fpm = new FamilyPlanTypeSubcategories();
        $obj = json_decode($request->getContent(), true);
        $details = $fpm->details($obj);

        return response([
            'name' => 'Search',
            'results' => $details,
        ], 200);
    }

    public function viewClinicByPatient($id)
    {
        $clinic = new Clinics();
        $fpm = new FamilyPlanTypeSubcategories();
        $details = $clinic->details($id);

        $services1 = $fpm->servicesOne($id);
        $services2 = $fpm->servicesTwo($id);
        $services3 = $fpm->servicesThree($id);

        $services = ['modernMethod' => $services1, 'permanentMethod' => $services2, 'naturalMethod' => $services3];

        $hours = DB::table('clinic_hours')
            ->select('days', 'froms', 'tos')
            ->where('clinic_id', $id)
            ->get();

        $gallery = DB::table('clinic_gallery')
            ->select('file_url')
            ->where('clinic_id', $id)
            ->get();

        return response([
            'name' => 'viewClinic',
            'data' => $details,
            'services' => $services,
            'operating_hours' => $hours,
            'gallery' => $gallery,
        ]);
    }

    public function viewClinic()
    {
        $details = DB::table('clinics')
            ->select('clinics.id', 'paid_service as free_consultation', 'clinics.clinic_name', 'clinics.photo_url', 'clinics.street_address', 'clinics.philhealth_accredited_1', 'clinics.type')
            ->where('is_approve', 1)
            ->where('user_id', 0)
            ->where('is_close', '<>', 1)
            ->get();

        return response([
            'name' => 'viewClinic',
            'data' => $details,
        ]);
    }

    public function selectedService($id)
    {
        $details = DB::table('family_plan_type_subcategory')
            ->select('id', 'family_plan_type_id', 'name', 'short_name', 'icon_url', 'percent_effective')
            ->where('id', $id)
            ->get();

        return response([
            'name' => 'SelectedService',
            'details' => $details,
        ]);
    }

    public function postMethod(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);

        Booking::create([
            'patient_id' => $id,
            'service_id' => $obj['method'][0],
        ]);

        $details = DB::table('booking')
            ->select('patient_id', 'service_id', 'id')
            ->where('patient_id', $id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->get();

        return response([
            'name' => 'postMethod',
            'details' => $details,
        ]);
    }

    public function province($id)
    {
        $getDetails = DB::table('booking')
            ->select('clinic_id', 'service_id', 'id')
            ->where('patient_id', $id)
            ->orderBy('id', 'desc')
            ->pluck('service_id');
        $data = [];
        $provinces = DB::table('clinics')
            ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.province')
            ->where('clinic_service.service_id', $getDetails[0])
            ->where('clinics.province', '<>', null)
            ->where('clinics.is_approve', 1)
            ->where('clinics.is_close', '<>', 1)
            ->distinct('clinics.province')
            ->get();
        $data = $provinces;
        return response([
            'name' => 'provinces',
            'details' => $data,
        ]);
    }

    public function city($id, $province)
    {
        $getDetails = DB::table('booking')
            ->select('clinic_id', 'service_id', 'id')
            ->where('patient_id', $id)
            ->orderBy('id', 'desc')
            ->pluck('service_id');
        $data = [];
        $provinces = DB::table('clinics')
            ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.city')
            ->distinct('clinics.city')
            ->where('clinic_service.service_id', $getDetails[0])
            ->where('city', '<>', null)
            ->where('clinics.is_approve', 1)
            ->where('clinics.is_close', '<>', 1)
            ->where('clinics.province', $province)
            ->get();
        $data = $provinces;
        return response([
            'name' => 'city',
            'details' => $data,
        ]);
    }

    public function municipality($id)
    {
        $getDetails = DB::table('booking')
            ->select('clinic_id', 'service_id', 'id')
            ->where('patient_id', $id)
            ->orderBy('id', 'desc')
            ->pluck('service_id');
        $data = [];
        $provinces = DB::table('clinics')
            ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.municipality')
            ->distinct('clinics.municipality')
            ->where('municipality', '<>', null)
            ->where('clinics.is_approve', 1)
            ->where('clinics.is_close', '<>', 1)
            ->where('clinic_service.service_id', $getDetails[0])
            ->get();
        $data = $provinces;
        return response([
            'name' => 'municipality',
            'details' => $data,
        ]);
    }

    public function postClinic(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        DB::update('update booking set clinic_id = ? where patient_id = ? order by id desc limit 1', [$obj['clinic'][0], $id]);

        return response([
            'name' => 'PostMethod',
            'message' => 'clinic posted',
        ]);
    }
    private function age($bdate)
    {
        return Carbon::createFromDate($bdate)->age;
    }
}
