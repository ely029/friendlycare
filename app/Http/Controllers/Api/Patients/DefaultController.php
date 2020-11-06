<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Booking;
use App\FpmMethods;
use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\MedicalHistory;
use App\MedicalHistoryAnswer;
use App\Patients;
use App\Spouses;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class DefaultController extends Controller
{
    public function login()
    {
        $this->validate(request(), [
            'email' => 'required|string|email',
            'password' => 'required|min:6',
        ]);

        if (\Auth::attempt(['email' => request('email'), 'password' => request('password'), 'role_id' => 3])) {
            $user = \Auth::user();

            return response([
                'login_success' => 'Login Successful',
                'id' => $user['id'],
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
        $users = User::where('email', $request['email'])->get();

        Mail::send('email.patient.account-verification', ['users' => $users], function ($mail) use ($request) {
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

        $users = User::where('email', $request['email'])->get();

        Mail::send('email.patient.account-reset', ['users' => $users], function ($mail) use ($request) {
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

        $user = User::create($request);

        $request['user_id'] = $user->id;
        $request['patient_id'] = $user->id;

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
        'patients.city',
        'patients.citymunicipality',
        'patients.province',
        'users.contact_number_1',
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
        'patients.citymunicipality',
        'patients.province',
        'users.contact_number_1',
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
        'users.contact_number_1',
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
        $modernMethods = DB::table('family_plan_type_subcategory')
            ->leftJoin('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', DB::raw('null as is_checked'))
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('fpm_methods.is_checked', null);

        $permanentMethods = DB::table('family_plan_type_subcategory')
            ->leftJoin('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', DB::raw('null as is_checked'))
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('fpm_methods.is_checked', null);

        $naturalMethods = DB::table('family_plan_type_subcategory')
            ->leftJoin('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', DB::raw('null as is_checked'))
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('fpm_methods.is_checked', null);

        $modernMethodsFpmMethods = DB::table('family_plan_type_subcategory')
            ->join('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'fpm_methods.is_checked')
            ->where('fpm_methods.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('fpm_methods.patient_id', $id);

        $permanentMethodsFpmMethods = DB::table('family_plan_type_subcategory')
            ->join('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'fpm_methods.is_checked')
            ->where('fpm_methods.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('fpm_methods.patient_id', $id);

        $naturalMethodsFpmMethods = DB::table('family_plan_type_subcategory')
            ->join('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'fpm_methods.is_checked')
            ->where('fpm_methods.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('fpm_methods.patient_id', $id);

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

        $modernMethods = DB::table('family_plan_type_subcategory')
            ->leftJoin('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', DB::raw('null as is_checked'))
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('fpm_methods.is_checked', null);

        $permanentMethods = DB::table('family_plan_type_subcategory')
            ->leftJoin('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', DB::raw('null as is_checked'))
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('fpm_methods.is_checked', null);

        $naturalMethods = DB::table('family_plan_type_subcategory')
            ->leftJoin('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', DB::raw('null as is_checked'))
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('fpm_methods.is_checked', null);

        $modernMethodsFpmMethods = DB::table('family_plan_type_subcategory')
            ->join('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'fpm_methods.is_checked')
            ->where('fpm_methods.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('fpm_methods.patient_id', $id);

        $permanentMethodsFpmMethods = DB::table('family_plan_type_subcategory')
            ->join('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'fpm_methods.is_checked')
            ->where('fpm_methods.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('fpm_methods.patient_id', $id);

        $naturalMethodsFpmMethods = DB::table('family_plan_type_subcategory')
            ->join('fpm_methods', 'fpm_methods.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'fpm_methods.is_checked')
            ->where('fpm_methods.is_checked', 1)
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('fpm_methods.patient_id', $id);

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
        $modernMethod = DB::table('family_plan_type_subcategory')
            ->select('name', 'short_name', 'percent_effective', DB::raw("'Modern Method' as method_name"))
            ->where('family_plan_type_id', 1)
            ->where('is_approve', 1)
            ->get();

        $permanentMethod = DB::table('family_plan_type_subcategory')
            ->select('name', 'short_name', 'percent_effective', DB::raw("'Natural Method' as method_name"))
            ->where('family_plan_type_id', 2)
            ->where('is_approve', 1)
            ->get();

        $naturalMethod = DB::table('family_plan_type_subcategory')
            ->select('name', 'short_name', 'percent_effective', DB::raw("'Natural Method' as method_name"))
            ->where('family_plan_type_id', 3)
            ->where('is_approve', 1)
            ->get();

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
        $obj = json_decode($request->getContent(), true);
        $details = DB::table('family_plan_type_subcategory')
            ->select('id', 'icon_url', 'name', 'short_name', 'percent_effective', DB::raw("'Modern Method' as method_name"))
            ->where('name', 'like', '%' . $obj['search'][0] . '%')
            ->orWhere('description_filipino', 'like', '%' . $obj['search'][0] . '%')
            ->orWhere('description_english', 'like', '%' . $obj['search'][0] . '%')
            ->get();

        return response([
            'name' => 'Search',
            'results' => $details,
        ], 200);
    }

    public function viewClinicByPatient($id)
    {
        $details = DB::table('clinics')
            ->select(
               'clinics.id',
               'clinics.email',
               'clinics.contact_number',
               'clinics.street_address',
               'clinics.description',
               'clinics.clinic_name',
               'clinics.city',
               'clinics.province',
               'clinics.municipality',
               'clinics.photo_url',
               'clinics.type',
               )
            ->where('clinics.id', $id)
            ->where('is_approve', 1)
            ->get();

        $services1 = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where(['clinics.id' => $id, 'clinics.is_approve' => 1])
            ->get();

        $services2 = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where(['clinics.id' => $id, 'clinics.is_approve' => 1])
            ->get();

        $services3 = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where(['clinics.id' => $id, 'clinics.is_approve' => 1])
            ->get();

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
            ->where('clinic_name', '<>', null)
            ->where('type', '<>', null)
            ->where('photo_url', '<>', null)
            ->where('paid_service', '<>', null)
            ->get();

        return response([
            'name' => 'viewClinic',
            'data' => $details,
        ]);
    }

    public function searchClinic(Request $request)
    {
        $obj = json_decode($request->getContent(), true);
        $details = DB::table('clinics')
            ->select('clinics.id', 'clinics.type', 'clinics.photo_url', 'clinics.clinic_name', 'clinics.city', 'clinics.paid_service as free_consultation', 'clinics.philhealth_accredited_1')
            ->Where('province', 'like', '%' . $obj['province'][0] . '%')
            ->Where('city', 'like', '%' . $obj['city'][0] . '%')
            ->Where('municipality', 'like', '%' . $obj['municipality'][0] . '%')
            ->Where('philhealth_accredited_1', 'like', '%' . $obj['philhealth_accredited'][0] . '%')
            ->Where('paid_service', 'like', '%' . $obj['paid_service'][0] . '%')
            ->where('clinics.user_id', 0)
            ->get();

        return response([
            'name' => 'searchClinic',
            'details' => $details,
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
            ->distinct('clinics.province')
            ->get();
        $data = $provinces;
        return response([
            'name' => 'provinces',
            'details' => $data,
        ]);
    }

    public function city($id)
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
