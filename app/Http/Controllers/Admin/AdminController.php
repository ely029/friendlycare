<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function authenticate()
    {
        if (\Auth::attempt(['email' => request('email'), 'password' => request('password'), 'role_id' => [1,2]])) {
            return redirect('admin');
        }
        return redirect('/')
            ->withErrors('Email and password are invalid!')
            ->withInput();
    }

    public function index()
    {
        return view('admin.index');
    }

    public function accounts()
    {
        return view('admin.accounts');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function changePassword()
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'new-password' => 'required',
            'old-password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/accounts')
                ->withErrors($validator)
                ->withInput();
        }
        //check if the old password is match
        $oldpassword = $request['old-password'];
        $newpassword = $request['new-password'];
        if ($oldpassword === $newpassword) {
            return redirect('admin/accounts')
                ->withErrors('Old and new password are the same. please choose another password')
                ->withInput();
        }
        User::where('email', $request['email'])->update([
            'password' => bcrypt($request['new-password']),
        ]);
        return back()->with('message', 'Password updated successfully');
    }
}
