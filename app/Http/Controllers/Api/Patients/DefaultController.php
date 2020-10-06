<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Http\Controllers\Controller;
use App\Patients;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function login()
    {
        $this->validate(request(), [
            'email' => 'required|string|email',
            'password' => 'required|min:6',
        ]);

        if (\Auth::attempt(['email' => request('email'), 'password' => request('password'), 'role_id' => 3])) {
            
            $user = auth()->user();
            return response([
                'messages' => 'Login Successful',
                'httpCode' => 200,
                'id' => $user->id
            ]);
        }
        return response([
            'errorCode' => '',
            'message' => 'Email and password are invalid',
            'httpCode' => 422,
        ], 404);
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

        $user = User::create($request);

        $request['user_id'] = $user->id;
        Patients::create($request);

        return response()->json('Congratulations! You are registered.', 200);
    }

    private function age($bdate)
    {
        return Carbon::createFromDate($bdate)->age;
    }

    public function getAllUsers()
    {
        $users = User::where('role_id', 3)->get();
        return response($users);
    }

    public function getUserById()
    {
        $request = request()->all();
        $users = User::where('id', $request['id'])->get();

        return response($users);
    }
}
