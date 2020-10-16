<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\ClinicHours;
use App\Clinics;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProviderManagementController extends Controller
{
    public function index()
    {
        $users = DB::table('clinics')
            ->select('clinics.email', 'clinics.type', 'clinics.id', 'clinics.clinic_name')
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
        $provider = DB::table('clinics')
            ->leftJoin('clinic_hours', 'clinic_hours.clinic_id', 'clinics.id')
            ->select(
                'clinics.clinic_name',
                'clinics.city',
                'clinics.province',
                'clinics.contact_number',
                'clinics.municipality',
                'clinics.email',
                'clinics.description',
                'clinics.type',
                'clinics.street_address',
                'clinics.id',
           )
            ->where(['clinics.id' => $id, 'clinics.is_approve' => 1])
            ->whereNotNull('clinics.clinic_name')
            ->get();

        return view('admin.providerManagement.editProviderInformation', ['provider' => $provider ]);
    }

    public function editPage($id)
    {
        $provider = DB::table('clinics')
            ->leftJoin('clinic_hours', 'clinic_hours.clinic_id', 'clinics.id')
            ->select(
                'clinics.clinic_name',
                'clinics.city',
                'clinics.province',
                'clinics.contact_number',
                'clinics.municipality',
                'clinics.email',
                'clinics.description',
                'clinics.type',
                'clinics.street_address',
                'clinics.id',
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
            'city' => $request['city'],
            'municipality' => $request['municipality'],
            'province' => $request['province'],
            'email' => $request['email'],
        ]);
        return redirect('/provider/list');
    }

    public function deleteProvider($id)
    {
        Clinics::where('id', $id)->delete();
        ClinicHours::where('clinic_id', $id)->delete();

        return redirect('provider/list');
    }

    public function storeFirstPage()
    {
        $request = request()->all();
        $request['profession'] = 'N/A';
        $request['training'] = 'N/A';
        Clinics::create($request);
        $user = Clinics::where('email', $request['email'])->get();
        session(['id' => $user->id]);

        return redirect()->action('Admin\ProviderManagementController@createSecondPage');
    }

    public function storeSecondPage()
    {
        $request = request()->all();
        ClinicHours::create([
            'clinic_id' => session('id'),
            'days' => json_encode($request['days']),
            'froms' => json_encode($request['from']),
            'tos' => json_encode($request['to']),
            'is_checked' => 1,
        ]);
        return redirect()->action('Admin\ProviderManagementController@createThirdPage');
    }

    public function storeThirdPage()
    {
        Clinics::where('id', session('id'))->update(['is_approve' => 1]);

        return redirect('/provider/profile/'.session('id'));
    }
}
