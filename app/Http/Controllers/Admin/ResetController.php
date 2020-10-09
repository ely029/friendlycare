<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;

class ResetController extends Controller
{
    public function index($id)
    {
        return view('reset.index', ['id' => $id]);
    }

    public function updatePassword()
    {
        $request = request()->all();
        User::where('id', $request['id'])->update([
            'password' => bcrypt($request['password']),
        ]);

        return view('reset.thankyou');
    }
}
