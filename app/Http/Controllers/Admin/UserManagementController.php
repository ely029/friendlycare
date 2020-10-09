<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Clinics;
use App\Http\Controllers\Controller;
use App\Staffs;
use App\User;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
            ->leftJoin('clinics', 'clinics.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.first_name', 'users.last_name', 'clinics.clinic_name', 'users.role_id', 'users.email')
            ->orderBy('users.created_at', 'desc')
            ->where('users.role_id', '<>', 3)
            ->get();
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
        $users = DB::table('users')
            ->join('clinics', 'clinics.user_id', '=', 'users.id')
            ->select('clinics.id', 'clinics.clinic_name')
            ->where('is_approve', 1)
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
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        $request['role_id'] = 2;

        if ($validator->fails()) {
            return redirect('user/create/admin/1')
                ->withErrors($validator)
                ->withInput();
        }
        $request['password'] = bcrypt($request['password']);
        $request['name'] = $request['first_name'] . ' ' . $request['last_name'];

        $user = User::create([
            'name' => $request['name'],
            'password' => $request['password'],
            'email' => $request['email'],
        ]);

        Clinics::create([
            'profession' => $request['profession'],
            'training' => $request['training'],
        ]);

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
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        $request['role_id'] = 4;

        if ($validator->fails()) {
            return redirect('user/create/staff/1')
                ->withErrors($validator)
                ->withInput();
        }
        $request['password'] = bcrypt($request['password']);
        $request['name'] = $request['first_name'] . ' ' . $request['last_name'];
        $request['clinic_id'] = $request['clinic'];

        $user = User::create($request);
        $request['user_id'] = $user->id;
        Staffs::create($request);

        return redirect('user/page/'.$user->id);
    }
    public function editUserProfilePage($id)
    {
        $user = User::where('id', $id)->get();

        return view('admin.userManagement.adminEditProfilePage', ['users' => $user]);
    }
    public function editUserProfile($id)
    {
        $user = User::where('id', $id)->get();

        return view('admin.userManagement.adminEditProfile', ['users' => $user]);
    }
    public function updateUser()
    {
        $request = request()->all();

        User::find($request['id'])->update([
            'name' => $request['first_name'] . ' ' . $request['last_name'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'profession' => $request['profession'],
            'training' => $request['training'],
            'email' => $request['email'],
        ]);

        return redirect('/user/list');
    }

    public function deleteUser($id)
    {
        User::where('id', $id)->delete();

        return redirect('/user/list');
    }
}
