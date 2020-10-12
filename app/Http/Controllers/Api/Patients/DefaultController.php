<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Patients;
use App\Spouses;
use App\User;
use Carbon\Carbon;
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
        'users.city',
        DB::raw('CONCAT(users.city, users.municipality) AS citymunicipality'),
        'users.province',
        'users.contact_number_1',
        'patients.religion',
        'patients.occupation',
        'patients.street_address',
        'patients.monthly_income',
        'patients.no_of_living_children',
        'patients.family_plan_type_id',
        'patients.barangay',
        'spouses.spouse_first_name',
        'spouses.spouse_last_name',
        'spouses.spouse_middle_initial',
        'spouses.spouse_occupation',
        'spouses.spouse_birth_date',
        'patients.do_you_have_plan_children',
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
        'users.id',
        'users.last_name',
        'users.middle_initial',
        'users.birth_date',
        'users.gender',
        'users.email',
        'users.age',
        'users.city',
        DB::raw('CONCAT(users.city, users.municipality) AS citymunicipality'),
        'users.province',
        'users.contact_number_1',
        'patients.religion',
        'patients.occupation',
        'patients.street_address',
        'patients.monthly_income',
        'patients.no_of_living_children',
        'patients.family_plan_type_id',
        'patients.barangay',
        'spouses.spouse_first_name',
        'spouses.spouse_last_name',
        'spouses.spouse_middle_initial',
        'spouses.spouse_occupation',
        'spouses.spouse_birth_date',
        'patients.do_you_have_plan_children',
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
            'municipality' => $request['municipality'],
            'city' => $request['city'],
            'province' => $request['province'],
        ]);
        Patients::where('user_id', $request['id'])->update([
            'religion' => $request['religion'],
            'monthly_income' => $request['monthly_income'],
            'no_of_living_children' => $request['no_living_children'],
            'do_you_have_plan_children' => $request['do_you_have_plan_children'],
            'street_address' => $request['street_address'],
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
        'users.city',
        DB::raw('CONCAT(users.city, users.municipality) AS citymunicipality'),
        'users.province',
        'users.contact_number_1',
        'patients.religion',
        'patients.occupation',
        'patients.street_address',
        'patients.monthly_income',
        'patients.no_of_living_children',
        'patients.family_plan_type_id',
        'patients.barangay',
        'spouses.spouse_first_name',
        'spouses.spouse_last_name',
        'spouses.spouse_middle_initial',
        'spouses.spouse_occupation',
        'spouses.spouse_birth_date',
        'patients.do_you_have_plan_children',
         )
            ->where('users.id', $request['id'])
            ->get();

        return response()->json($users, 200);
    }

    private function age($bdate)
    {
        return Carbon::createFromDate($bdate)->age;
    }
}
