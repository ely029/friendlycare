<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\ClinicHours;
use App\Clinics;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;

class ProviderManagementController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
            ->join('clinics', 'clinics.user_id', '=', 'users.id')
            ->select('users.email', 'clinics.clinic_name', 'clinics.id')
            ->where('is_approve', 1)
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

    public function editProviderInformation()
    {
        return view('admin.providerManagement.editProviderInformation');
    }

    public function editPage($id)
    {
        $provider = DB::table('users')
            ->leftJoin('clinics', 'clinics.user_id', 'users.id')
            ->leftJoin('clinic_hours', 'clinic_hours.clinic_id', 'clinics.id')
            ->select(
               'users.first_name',
               'users.last_name',
               'clinics.clinic_name',
               'users.city',
               'users.province',
               'users.municipality',
               'users.email',
               'users.profession',
               'users.training',
               'users.contact_number',
               'clinics.type',
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
        Clinics::where('user_id', $request['clinic_id'])->update([
            'clinic_name' => $request['clinic_name'],
        ]);

        User::where('id', $request['user_id'])->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'province' => $request['province'],
            'municipality' => $request['municipality'],
            'city' => $request['city'],
            'profession' => $request['profession'],
            'contact_number' => $request['contact_number'],
            'training' => $request['training'],
            'email' => $request['email'],
        ]);

        return redirect('/provider/list');
    }

    public function storeFirstPage()
    {
        $request = request()->all();
        //check if the email is registered
        $user = User::where(['email' => $request['email'],'role_id' => 2])->first();
        if ($user === null) {
            return redirect('/provider/create/1')->with('message', 'Email are not registered as Admin!');
        }

        $userid = Clinics::where(['user_id' => $user->id])->first();

        if ($userid !== null) {
            return redirect('/provider/create/1')->with('message', 'Email are already used by other clinic');
        }

        $request['user_id'] = $user->id;
        session(['id' => $user->id]);

        Clinics::create($request);

        return redirect()->action('Admin\ProviderManagementController@createSecondPage');
    }

    public function storeSecondPage()
    {
        $request = request()->all();

        $request['day'] = $request['days'];
        $request['clinic_id'] = $request['id'];
        ClinicHours::create([
            'clinic_id' => $request['id'],
            'day' => json_encode($request['day']),
            'from' => json_encode($request['from']),
            'to' => json_encode($request['to']),
        ]);
        return redirect()->action('Admin\ProviderManagementController@createThirdPage');
    }

    public function storeThirdPage()
    {
        Clinics::where('user_id', session('id'))->update(['is_approve' => 1]);

        return redirect('/provider/profile');
    }
}
