<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Clinics;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;

class ProviderManagementController extends Controller
{
    public function index()
    {
        $users = DB::table('clinics')
            ->join('users', 'clinics.user_id', '=', 'users.id')
            ->join('staffs', 'staffs.user_id', 'users.id')
            ->select('users.email', 'clinics.clinic_name', 'clinics.id', 'users.id AS admin_id')
            ->whereNotNull('clinics.clinic_name')
            ->where(['clinics.is_approve' => 1])
            ->get();

        return view('admin.providerManagement.index', ['clinics' => $users]);
    }

    public function createFirstPage()
    {
        return view('admin.providerManagement.createProviderFirstPage');
    }

    public function createSecondPage()
    {
        return view('admin.providerManagement.createProviderSecondPage');
    }

    public function createThirdPage()
    {
        return view('admin.providerManagement.createProviderThirdPage');
    }

    public function editProviderInformation($id)
    {
        $provider = DB::table('users')
            ->leftJoin('clinics', 'clinics.user_id', 'users.id')
            ->leftJoin('clinic_hours', 'clinic_hours.clinic_id', 'clinics.id')
            ->select(
                'clinics.clinic_name',
                'users.city',
                'users.province',
                'users.contact_number_1',
                'users.municipality',
                'users.email',
                'clinics.description',
                'clinics.type',
                'clinics.street_address',
                'clinics.id as c_id',
                'users.id AS users_id',
           )
            ->where(['users.id' => $id, 'clinics.is_approve' => 1])
            ->whereNotNull('clinics.clinic_name')
            ->get();

        return view('admin.providerManagement.editProviderInformation', ['provider' => $provider ]);
    }

    public function editPage($id)
    {
        $provider = DB::table('users')
            ->leftJoin('clinics', 'clinics.user_id', 'users.id')
            ->leftJoin('clinic_hours', 'clinic_hours.clinic_id', 'clinics.id')
            ->select(
                'clinics.clinic_name',
                'users.city',
                'users.province',
                'clinics.contact_number',
                'users.municipality',
                'users.email',
                'clinics.description',
                'clinics.type',
                'clinics.street_address',
                'clinics.id as c_id',
                'users.id AS users_id',
               )
            ->where('clinics.id', $id)
            ->get();

        return view('admin.providerManagement.editPage', ['provider' => $provider]);
    }

    public function updateProvider()
    {
        $request = request()->all();
        Clinics::where('id', $request['clinic_id'])->update([
            'clinic_name' => $request['clinic_name'],
            'street_address' => $request['street_address'],
            'description' => $request['description'],
            'contact_number' => $request['contact_number'],
        ]);

        User::where('id', $request['user_id'])->update([
            'province' => $request['province'],
            'municipality' => $request['municipality'],
            'city' => $request['city'],
            'email' => $request['email'],
        ]);

        return redirect('/provider/list');
    }

    public function deleteProvider($id)
    {
        Clinics::where('id', $id)->delete();

        return redirect('provider/list');
    }

    public function storeFirstPage()
    {
        $request = request()->all();
        //check if the email is registered
        $user = User::where(['email' => $request['email'],'role_id' => 2])->first();
        if ($user === null) {
            return redirect('/provider/create/1')->with('message', 'Email are not registered as Admin!');
        }

        $userid = Clinics::where(['user_id' => $user->id,'is_approve' => 1])->first();

        if ($userid !== null) {
            return redirect('/provider/create/1')->with('message', 'Email are already used by other clinic');
        }

        $request['user_id'] = $user->id;
        $request['profession'] = 'N/A';
        $request['training'] = 'N/A';
        session(['id' => $user->id]);

        Clinics::where('user_id', $request['user_id'])->update([
            'user_id' => $request['user_id'],
            'clinic_name' => $request['clinic_name'],
            'description' => $request['description'],
            'street_address' => $request['address'],
            'contact_number' => $request['contact_number'],
        ]);

        User::where('id', $request['user_id'])->update([
            'city' => $request['city'],
            'municipality' => $request['municipality'],
            'province' => $request['province'],
        ]);

        return redirect()->action('Admin\ProviderManagementController@createSecondPage');
    }

    public function storeSecondPage()
    {
        return redirect()->action('Admin\ProviderManagementController@createThirdPage');
    }

    public function storeThirdPage()
    {
        Clinics::where('user_id', session('id'))->update(['is_approve' => 1]);

        return redirect('/provider/profile/'.session('id'));
    }
}
