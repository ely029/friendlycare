<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function authenticate()
    {
        if (\Auth::attempt(['email' => request('email'), 'password' => request('password'), 'role_id' => [1,2]])) {
            return redirect('admin');
        }
        return redirect('portal')
            ->withErrors('Email and password are invalid!')
            ->withInput();
    }

    public function index()
    {
        return view('admin.index');
    }

    public function showLogin()
    {
        return view('admin.login');
    }

    public function accounts()
    {
        return view('admin.accounts');
    }
}
