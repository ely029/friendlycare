<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\ClinicHours;
use App\Clinics;
use App\Http\Controllers\Controller;
use App\User;

class ProviderManagementController extends Controller
{
    public function index()
    {
        return view('admin.providerManagement.index');
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

    public function editProviderProfile()
    {
        //provider info
        return view('admin.providerManagement.editProviderProfile');
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
        User::find(session('id'))->update([
            'is_approved' => 1,
        ]);

        return redirect('/provider/profile');
    }
}
