<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Clinics;
use App\Http\Controllers\Controller;
use App\Staffs;
use App\User;
use Illuminate\Support\Facades\DB;
use Mail;

class UserManagementController extends Controller
{
    public function index()
    {
        $user = new User();
        $users = '';
        $staffs = $user->getStaff();
        $admin = $user->getAdmin();
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
        $users = Clinics::where('is_approve', 1)->get();

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
        $id = DB::table('users')->select('id')->where('id', $user->id)->pluck('id');
        Mail::send('email.patient.account-set-password', ['id' => $id[0]], function ($mail) use ($request) {
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

        $id = DB::table('users')->select('id')->where('id', $user->id)->pluck('id');

        Mail::send('email.patient.account-set-password', ['id' => $id[0]], function ($mail) use ($request) {
            $mail->from('no-reply@friendlycare.com');
            $mail->to([$request['email'], 'superadmin@fc.com'])->subject('Password Setup');
        });

        return redirect('user/page/'.$user->id);
    }
    public function editUserProfilePage($id)
    {
        $clinics = new Clinics();
        $user = User::where('id', $id)->get();
        $clinic = $clinics->getClinicByStaff($id);
        $staff = $clinics->getClinicByStaffOne($id);
        return view('admin.userManagement.adminEditProfilePage', ['users' => $user, 'clinic' => $clinic, 'staff' => $staff]);
    }
    public function editUserProfile($id)
    {
        $clinic = new Clinics();
        $user = User::where('id', $id)->get();
        $clinic = $clinic->getClinic();
        $selected_clinic_name = DB::table('staffs')->join('clinics', 'clinics.id', 'staffs.clinic_id')->select('clinics.clinic_name')->where('staffs.user_id', $id)->pluck('clinic_name');
        $selected_clinic_id = DB::table('staffs')->join('clinics', 'clinics.id', 'staffs.clinic_id')->select('clinics.id')->where('staffs.user_id', $id)->pluck('id');

        return view('admin.userManagement.adminEditProfile', ['users' => $user, 'clinic' => $clinic, 'selected_clinic_name' => $selected_clinic_name[0] ?? null, 'selected_clinic_id' => $selected_clinic_id[0] ?? null]);
    }
    public function updateUser()
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('user/edit/'.$request['id'])
                ->withErrors($validator)
                ->withInput();
        }
        if ($request['role_id'] === '2') {
            User::find($request['id'])->update([
                'name' => $request['first_name'] . ' ' . $request['last_name'],
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'professions' => $request['professions'],
                'trainings' => $request['trainings'],
            ]);
        } else {
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
        }

        return redirect('/user/list');
    }

    public function deleteUser($id)
    {
        DB::delete('delete from users where id = ?', [$id]);
        Staffs::where('user_id', $id)->delete();

        return redirect('/user/list');
    }

    public function filter()
    {
        $users = '';
        $request = request()->all();
        $user = new User();

        if ($request['filter'] === 'by_admin') {
            $users = $user->getAdmin();
        } elseif ($request['filter'] === 'by_staff') {
            $users = $user->getStaff();
        } else {
            $staffs = $user->getStaff();
            $admin = $user->getAdmin();
            $users = $staffs->union($admin)->get();
        }
        return view('admin.userManagement.index', ['admin' => $users]);
    }

    public function search()
    {
        $request = request()->all();
        if ($request['search'] === 'Staff') {
            $user = User::where('role_id', 4)->get();
            return view('admin.userManagement.index', ['admin' => $user]);
        }
        if ($request['search'] === 'Admin') {
            $user = User::where('role_id', 2)->get();
            return view('admin.userManagement.index', ['admin' => $user]);
        }
        if ($request['search'] === 'All') {
            $user = User::where('role_id', '<>', 3)->where('role_id', '<>', 1)->get();
            return view('admin.userManagement.index', ['admin' => $user]);
        }
    }

    public function emailResetPassword($id)
    {
        $users = DB::table('users')->select('id')->where('id', $id)->pluck('id');
        $getEmail = DB::table('users')->select('email')->where('id', $id)->pluck('email');
        Mail::send('email.patient.account-reset', ['users' => $users[0]], function ($mail) use ($getEmail) {
            $mail->from('no-reply@friendlycare.com');
            $mail->to($getEmail[0], 'Staff')->subject('Reset Password');
        });

        return redirect('/user/list');
    }
}
