<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin.userManagement.index', ['users' => $users]);
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
        return view('admin.userManagement.staffFirstPage');
    }

    public function createAdmin()
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|',
            'confirm_password' => 'required|same:password',
        ]);

        $request['role_id'] = 2;

        if ($validator->fails()) {
            return redirect('user/create/admin/1')
                    ->withErrors($validator)
                    ->withInput();
        }

          $user = User::create($request);

          return redirect('user/admin/'.$user->id);
    }

    public function editAdminProfilePage($id)
    {
        $user = User::where('id', $id)->first();
            
        return view('admin.userManagement.adminEditProfilePage',['users' => $user]);
    }

    public function editAdminProfile($id)
    {
        $user = User::where('id', $id)->first();
    
        return view('admin.userManagement.adminEditProfile',['users' => $user]);
    }

    public function updateAdmin()
    {
        $request = request()->all();

        User::find($request['id'])->update([
            'first_name' => $request['first_name'],
            'last_name' =>  $request['last_name'],
            'profession' => $request['profession'],
            'training' =>   $request['training'] 
        ]);

        return redirect('/user/list');
    }
}
