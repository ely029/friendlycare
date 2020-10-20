<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\ClinicGallery;
use App\ClinicHours;
use App\Clinics;
use App\ClinicService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderManagementController extends Controller
{
    public function index()
    {
        $users = DB::table('clinics')
            ->select('clinics.email', 'clinics.type', 'clinics.id', 'clinics.clinic_name')
            ->where('clinics.email', '<>', 'null')
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
        $modernMethod = DB::table('family_plan_type_subcategory')
            ->select('name', 'id')
            ->where('family_plan_type_id', 1)
            ->where('is_approve', 1)
            ->get();

        $permanentMethod = DB::table('family_plan_type_subcategory')
            ->select('name', 'id')
            ->where('family_plan_type_id', 2)
            ->where('is_approve', 1)
            ->get();

        $naturalMethod = DB::table('family_plan_type_subcategory')
            ->select('name', 'id')
            ->where('family_plan_type_id', 3)
            ->where('is_approve', 1)
            ->get();
        return view('admin.providerManagement.createProviderThirdPage', ['modernMethod' => $modernMethod, 'permanentMethod' => $permanentMethod, 'naturalMethod' => $naturalMethod]);
    }

    public function editProviderInformation($id)
    {
        $provider = DB::table('clinics')
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

    public function storeFirstPage(Request $requests)
    {
        $validator = \Validator::make(request()->all(), [
            'email' => 'required|string|email|max:255|unique:clinics',
        ]);
        if ($validator->fails()) {
            return redirect('provider/create/1')
                ->withErrors($validator)
                ->withInput();
        }

        $request = request()->all();
        $request['profession'] = 'N/A';
        $request['training'] = 'N/A';

        $icon = $requests->file('pic');
        $destination = public_path('assets/app/img/');
        $icon_url = url('assets/app/img/'.$icon->getClientOriginalName());
        $icon->move($destination, $icon->getClientOriginalName());
        $request['photo_url'] = $icon_url;

        Clinics::create($request);
        $user = DB::table('clinics')->where('email', $request['email'])->pluck('id');
        session(['id' => $user[0]]);
        return view('admin.providerManagement.createProviderSecondPage');
    }

    public function storeSecondPage(Request $requests)
    {
        $request = request()->all();
        for ($files = 0;$files <= 4;$files++) {
            if (isset($requests->file('files')[$files])) {
                $icon = $requests->file('files')[$files];
                $destination = public_path('assets/app/img/');
                $icon_url = url('assets/app/img/'.$icon->getClientOriginalName());
                $icon->move($destination, $icon->getClientOriginalName());
                ClinicGallery::create([
                    'file_name' => $icon->getClientOriginalName(),
                    'clinic_id' => session('id'),
                    'file_url' => $icon_url,
                    'is_checked' => 1,
                ]);
            }
        }
        for ($clinic_hours = 0;$clinic_hours < 7;$clinic_hours++) {
            ClinicHours::create([
                'clinic_id' => session('id'),
                'id_value' => $clinic_hours,
                'days' => $request['days'][$clinic_hours],
                'froms' => $request['from'][$clinic_hours],
                'tos' => $request['to'][$clinic_hours],
                'is_checked' => 1,
            ]);
        }
        return redirect()->action('Admin\ProviderManagementController@createThirdPage');
    }

    public function storeThirdPage()
    {
        $request = request()->all();
        for ($modern = 0;$modern <= 1000;$modern++) {
            if (isset($request['modern'][$modern])) {
                ClinicService::create([
                    'service_id' => $request['modern'][$modern],
                    'clinic_id' => session('id'),
                    'is_checked' => 1,
                ]);
            }
        }
        for ($natural = 0;$natural <= 1000;$natural++) {
            if (isset($request['natural'][$natural])) {
                ClinicService::create([
                    'service_id' => $request['natural'][$natural],
                    'clinic_id' => session('id'),
                    'is_checked' => 1,
                ]);
            }
        }

        for ($permanent = 0;$permanent <= 1000;$permanent++) {
            if (isset($request['permanent'][$permanent])) {
                ClinicService::create([
                    'service_id' => $request['permanent'][$permanent],
                    'clinic_id' => session('id'),
                    'is_checked' => 1,
                ]);
            }
        }
        Clinics::where('id', session('id'))->update(['is_approve' => 1]);

        return redirect('/provider/profile/'.session('id'));
    }
}
