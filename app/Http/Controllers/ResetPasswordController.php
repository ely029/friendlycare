<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return view('reset.index');
    }
}
