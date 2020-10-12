<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Provider;

use App\Clinics;
use App\Http\Controllers\Controller;
use App\Staffs;
use App\User;
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

        if (\Auth::attempt(['email' => request('email'), 'password' => request('password'), 'role_id' => [2,4]])) {
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
        $users = User::where('id', $request['email'])->get();

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
        $users = User::where('id', $id)->with('clinics', 'staffs')->get();

        return response([
            'data' => $users,
        ]);
    }

    public function getAllUsers()
    {
        $users = User::with('clinics', 'staffs')->get();

        return response([
            'data' => $users,
        ]);
    }
}
