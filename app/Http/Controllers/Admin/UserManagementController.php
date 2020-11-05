<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Staffs;
use App\User;
use Illuminate\Support\Facades\DB;
use Mail;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = '';
        $staffs = DB::table('users')
            ->join('staffs', 'staffs.user_id', 'users.id')
            ->join('clinics', 'clinics.id', 'staffs.clinic_id')
            ->where('users.role_id', '<>', 1)
            ->where('users.role_id', '<>', 3)
            ->select('users.id', 'users.name', 'users.first_name', 'users.last_name', 'clinics.clinic_name', 'users.role_id', 'users.email');

        $admin = DB::table('users')
            ->select('users.id', 'users.name', 'users.first_name', 'users.last_name', 'users.email_verified_at as clinic_name', 'users.role_id', 'users.email')
            ->where('users.role_id', '<>', 1)
            ->where('users.role_id', '<>', 3)
            ->where('users.role_id', '<>', 4);

        $users = $staffs->union($admin)->get();
        return view('admin.userManagement.index', ['admin' => $users]);
    }
    public function role()
    {
        return view('admin.userManagement.role');
    }
    public function adminFirstPage()
    {
        return view('admin.userManagement.adminFirstPage');
    }
    public function staffFirstPage()
    {
        $users = DB::table('clinics')
            ->select('clinics.id', 'clinics.clinic_name')
            ->where('is_approve', 1)
            ->where('province', '<>', 'null')
            ->get();

        return view('admin.userManagement.staffFirstPage', ['clinics' => $users]);
    }
    public function createAdmin()
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
        $request['role_id'] = 2;

        if ($validator->fails()) {
            return redirect('user/create/admin/1')
                ->withErrors($validator)
                ->withInput();
        }
        $request['name'] = $request['first_name'] . ' ' . $request['last_name'];

        $user = User::create($request);
        $users = User::where('id', $user->id)->get();

        Mail::send('email.patient.account-set-password', ['users' => $users], function ($mail) use ($request) {
            $mail->from('no-reply@friendlycare.com');
            $mail->to([$request['email'], 'superadmin@fc.com'])->subject('Password Setup');
        });

        return redirect('user/page/'.$user->id);
    }

    public function createStaff()
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'first_name' => 'required',
            'clinic' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $request['role_id'] = 4;

        if ($validator->fails()) {
            return redirect('user/create/staff/1')
                ->withErrors($validator)
                ->withInput();
        }
        $request['name'] = $request['first_name'] . ' ' . $request['last_name'];
        $request['clinic_id'] = $request['clinic'];
        $count = DB::table('users')
            ->join('staffs', 'staffs.user_id', 'users.id')
            ->select('staffs.id')
            ->where('staffs.clinic_id', $request['clinic'])
            ->count();

        if ($count >= 5) {
            return redirect('user/create/staff/1')
                ->withErrors('The number of staffs are exceeded')
                ->withInput();
        }

        $user = User::create($request);
        $request['user_id'] = $user->id;
        Staffs::create($request);

        $users = User::where('id', $user->id)->get();

        Mail::send('email.patient.account-set-password', ['users' => $users], function ($mail) use ($request) {
            $mail->from('no-reply@friendlycare.com');
            $mail->to([$request['email'], 'superadmin@fc.com'])->subject('Password Setup');
        });

        return redirect('user/page/'.$user->id);
    }
    public function editUserProfilePage($id)
    {
        $user = User::where('id', $id)->get();
        $clinic = DB::table('clinics')
            ->join('staffs', 'staffs.clinic_id', 'clinics.id')
            ->select('clinics.clinic_name')
            ->where('staffs.user_id', $id)
            ->get();

        return view('admin.userManagement.adminEditProfilePage', ['users' => $user, 'clinic' => $clinic]);
    }
    public function editUserProfile($id)
    {
        $user = User::where('id', $id)->get();
        $clinic = DB::table('clinics')
            ->select('id', 'clinic_name')
            ->where('clinic_name', '<>', null)
            ->where('is_approve', '<>', 1)
            ->where('user_id', 0)
            ->get();

        return view('admin.userManagement.adminEditProfile', ['users' => $user, 'clinic' => $clinic]);
    }
    public function updateUser()
    {
        $request = request()->all();

        User::find($request['id'])->update([
            'name' => $request['first_name'] . ' ' . $request['last_name'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'professions' => $request['professions'],
            'trainings' => $request['trainings'],
        ]);

        Staffs::where('user_id', $request['id'])->update([
            'clinic_id' => $request['clinic'],
        ]);

        return redirect('/user/list');
    }

    public function deleteUser($id)
    {
        User::where('id', $id)->delete();
        Staffs::where('user_id', $id)->delete();

        return redirect('/user/list');
    }

    public function filter()
    {
        $users = '';
        $request = request()->all();

        if ($request['filter'] === 'by_admin') {
            $users = DB::table('users')
                ->select('users.id', 'users.name', 'users.first_name', 'users.last_name', 'users.email_verified_at as clinic_name', 'users.role_id', 'users.email')
                ->where('users.role_id', '<>', 1)
                ->where('users.role_id', '<>', 4)
                ->get();
        } elseif ($request['filter'] === 'by_staff') {
            $users = DB::table('users')
                ->join('staffs', 'staffs.user_id', 'users.id')
                ->join('clinics', 'clinics.id', 'staffs.clinic_id')
                ->select('users.id', 'users.name', 'users.first_name', 'users.last_name', 'clinics.clinic_name', 'users.role_id', 'users.email')
                ->get();
        } else {
            $staffs = DB::table('users')
                ->join('staffs', 'staffs.user_id', 'users.id')
                ->join('clinics', 'clinics.id', 'staffs.clinic_id')
                ->select('users.id', 'users.name', 'users.first_name', 'users.last_name', 'clinics.clinic_name', 'users.role_id', 'users.email');

            $admin = DB::table('users')
                ->select('users.id', 'users.name', 'users.first_name', 'users.last_name', 'users.email_verified_at as clinic_name', 'users.role_id', 'users.email')
                ->where('users.role_id', '<>', 1)
                ->where('users.role_id', '<>', 4);
            $users = $staffs->union($admin)->get();
        }
        return view('admin.userManagement.index', ['admin' => $users]);
    }

    public function search()
    {
        $request = request()->all();
        if ($request['search_by'] === 'id') {
            $user = User::where('id', $request['search'])->get();

            return view('admin.userManagement.index', ['admin' => $user]);
        }
        if ($request['search_by'] === 'role') {
            if ($request['search'] === 'Staff') {
                $user = User::where('role_id', 4)->get();
                return view('admin.userManagement.index', ['admin' => $user]);
            }
            if ($request['search'] === 'Admin') {
                $user = User::where('role_id', 2)->get();
                return view('admin.userManagement.index', ['admin' => $user]);
            }
        }
        if ($request['search_by'] === 'name') {
            $user = User::where('name', $request['search'])->get();

            return view('admin.userManagement.index', ['admin' => $user]);
        }
    }
}
