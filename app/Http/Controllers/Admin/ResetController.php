<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;

class ResetController extends Controller
{
    public function index($id)
    {
        $data = DB::table('users')
            ->leftJoin('staffs', 'staffs.user_id', 'users.id')
            ->leftJoin('clinics', 'clinics.id', 'staffs.clinic_id')
            ->select('users.email', 'users.id', 'clinics.clinic_name')
            ->where('users.id', $id)
            ->get();
        return view('reset.index', ['data' => $data]);
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
