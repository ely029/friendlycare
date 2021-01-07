<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PatientManagementController extends Controller
{
    public function index()
    {
        $details = DB::table('users')->leftjoin('patients', 'patients.user_id', 'users.id')->select('users.id', 'users.name', 'patients.province', 'users.email', 'users.age')->where('role_id', 3)->get();
        return view('admin.patientManagement.index', ['details' => $details]);
    }
}
