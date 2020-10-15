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
            ->select('users.first_name', 'users.last_name', 'users.email', 'staffs.profession', 'staffs.training')
            ->where('users.id', $id)
            ->get();

        return response([
            'data' => $users,
        ]);
    }

    public function getAllUsers()
    {
        $users = DB::table('staffs')
            ->join('users', 'users.id', 'staffs.user_id')
            ->select('users.first_name', 'users.last_name', 'users.email', 'staffs.profession', 'staffs.training')
            ->get();

        return response([
            'data' => $users,
        ]);
    }

    public function update()
    {
        $request = request()->all();
        User::where('id', $request['id'])->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
        ]);

        Staffs::where('user_id', $request['id'])->update([
            'profession' => $request['profession'],
            'training' => $request['training'],
        ]);

        $users = DB::table('staffs')
            ->join('users', 'users.id', 'staffs.user_id')
            ->select('users.first_name', 'users.last_name', 'users.email', 'staffs.profession', 'staffs.training')
            ->where('users.id', $request['id'])
            ->get();

        return response([
            'users' => $users,
        ]);
    }

    public function providerInfo()
    {
        $details = DB::table('clinics')
            ->leftjoin('users', 'users.id', 'clinics.user_id')
            ->leftjoin('staffs', 'staffs.user_id', 'users.id')
            ->leftjoin('clinic_hours', 'clinic_hours.clinic_id', 'users.id')
            ->select('users.email',
               'clinics.contact_number',
               'clinics.street_address',
               )
            ->get();

        return response([
            'data' => $details,
        ]);
    }
}
