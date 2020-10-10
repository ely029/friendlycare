<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function authenticate()
    {
        if (\Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            return redirect('admin');
        }

        return redirect('portal')->with('message', 'Email and password are invalid!');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function showLogin()
    {
        return view('admin.login');
    }
}
