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
        User::where('id', $request['id'])->update([
            'password' => bcrypt($request['password']),
        ]);

        return view('password.thankyou');
    }
}
