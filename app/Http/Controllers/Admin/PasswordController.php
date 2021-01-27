<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;

class PasswordController extends Controller
{
    public function index($id)
    {
        return view('password.index', ['id' => $id]);
    }

    public function readyPassword()
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect('reset/'.$request['id'])
                ->withErrors($validator)
                ->withInput();
        }
        User::where('id', $request['id'])->update([
            'password' => bcrypt($request['password']),
        ]);

        return view('password.thankyou');
    }
}
