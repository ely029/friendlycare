<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Provider;

use App\Clinics;
use App\Http\Controllers\Controller;
use App\Staffs;
use App\User;
use Illuminate\Support\Facades\DB;
use Mail;

class DefaultController extends Controller
{
    public function login()
    {
        $validator = \Validator::make(request()->all(), [
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (\Auth::attempt(['email' => request('email'), 'password' => request('password'), 'role_id' => 4])) {
            $user = \Auth::user();

            return response([
                'login_success' => 'Login Successful',
                'id' => $user['id'],
            ]);
        }
        return response([
            'message' => 'Uh Oh! Your email/password isn\'t right. Please check and retry',
        ], 422);
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
            $mail->to($request['email'], 'Staff')->subject('Reset Password');
        });
        return response([
            'message' => 'Email sent successfully',
        ], 200);
    }

    public function getUsersById($id)
    {
        $users = DB::table('staffs')
            ->join('users', 'users.id', 'staffs.user_id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.professions', 'users.trainings')
            ->where('staffs.user_id', $id)
            ->get();

        return response([
            'data' => $users,
        ]);
    }

    public function getAllStaff()
    {
        $users = DB::table('staffs')
            ->join('users', 'users.id', 'staffs.user_id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.professions', 'users.trainings')
            ->get();

        return response([
            'data' => $users,
        ]);
    }

    public function update($id)
    {
        $request = request()->all();
        User::where('id', $id)->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'professions' => $request['profession'],
            'trainings' => $request['training'],
        ]);

        $users = DB::table('staffs')
            ->join('users', 'users.id', 'staffs.user_id')
            ->select('users.first_name', 'users.last_name', 'users.email', 'users.professions', 'users.trainings')
            ->where('staffs.user_id', $id)
            ->get();

        return response([
            'users' => $users,
        ]);
    }

    public function providerInfo($id)
    {
        $user = Staffs::where('user_id', $id)->first();
        $details = DB::table('clinics')
            ->select('clinics.email',
               'clinics.contact_number',
               'clinics.street_address',
               'clinics.description',
               )
            ->where('clinics.id', $user['clinic_id'])
            ->get();

        return response([
            'data' => $details,
        ]);
    }

    public function getDescription($id)
    {
        $description = DB::table('staffs')
            ->join('clinics', 'clinics.id', 'staffs.clinic_id')
            ->select('clinics.description')
            ->where('staffs.user_id', $id)
            ->get();

        return response([
            'data' => $description,
        ]);
    }

    public function updateDescription($id)
    {
        $request = request()->all();
        $clinic = Staffs::where('user_id', $id)->first();
        Clinics::where('id', $clinic['clinic_id'])->update([
            'description' => $request['description'],
        ]);

        $description = Clinics::where('id', $clinic['clinic_id'])->first();

        return response([
            'data' => $description['description'],
        ]);
    }

    public function getAllProviders()
    {
        $provider = Clinics::where('is_approve', 1)->get();

        return response([
            'data' => $provider,
        ]);
    }

    public function getAllProvidersById($id)
    {
        $provider = Clinics::where(['is_approve' => 1, 'id' => $id])->get();

        return response([
            'data' => $provider,
        ]);
    }

    public function getClinicHours($id)
    {
        $schedules = DB::table('clinics')
            ->join('staffs', 'staffs.clinic_id', 'clinics.id')
            ->join('clinic_hours', 'clinic_hours.clinic_id', 'clinics.id')
            ->select('clinic_hours.days', 'clinic_hours.froms', 'clinic_hours.tos')
            ->where('staffs.user_id', $id)
            ->get();

        return response([
            'name' => 'ClinicHours',
            'schedule' => $schedules,
        ]);
    }
}
