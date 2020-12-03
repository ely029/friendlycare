<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\ClinicGallery;
use App\ClinicHours;
use App\Clinics;
use App\ClinicService;
use App\Http\Controllers\Controller;
use App\PaidServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderManagementController extends Controller
{
    public function index()
    {
        $users = DB::table('clinics')
            ->select('clinics.email', 'clinics.type', 'clinics.id', 'clinics.clinic_name')
            ->where('clinics.email', '<>', 'null')
            ->where('clinics.is_approve', '<>', 0)
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
                'clinics.philhealth_accredited_1',
                'clinics.photo_url',
           )
            ->where(['clinics.id' => $id, 'clinics.is_approve' => 1])
            ->whereNotNull('clinics.clinic_name')
            ->get();

        $modernMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->select('family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where(['clinics.id' => $id, 'clinics.is_approve' => 1])
            ->whereNotNull('clinics.clinic_name')
            ->get();

        $permanentMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->select('family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where(['clinics.id' => $id, 'clinics.is_approve' => 1])
            ->get();

        $naturalMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->select('family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where(['clinics.id' => $id, 'clinics.is_approve' => 1])
            ->get();

        $paidServices = DB::table('paid_services')
            ->join('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'paid_services.service_id')
            ->select('family_plan_type_subcategory.name')
            ->where('paid_services.clinic_id', $id)
            ->get();

        $staff = DB::table('staffs')
            ->join('users', 'users.id', 'staffs.user_id')
            ->select('users.first_name', 'users.last_name')
            ->where('staffs.clinic_id', $id)
            ->get();

        $clinicHours = DB::table('clinics')
            ->join('clinic_hours', 'clinic_hours.clinic_id', 'clinics.id')
            ->select('clinic_hours.days', 'clinic_hours.froms', 'clinic_hours.tos')
            ->where('clinic_hours.clinic_id', $id)
            ->get();

        $gallery = DB::table('clinic_gallery')
            ->join('clinics', 'clinics.id', 'clinic_gallery.clinic_id')
            ->select('clinic_gallery.file_name')
            ->where('clinic_gallery.clinic_id', $id)
            ->get();

        return view('admin.providerManagement.editProviderInformation', ['provider' => $provider, 'modernMethod' => $modernMethod, 'permanentMethod' => $permanentMethod, 'naturalMethod' => $naturalMethod, 'staffs' => $staff, 'paidServices' => $paidServices, 'clinicHours' => $clinicHours, 'galleries' => $gallery ]);
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
                'clinics.paid_service',
                'clinics.philhealth_accredited_1',
               )
            ->where('clinics.id', $id)
            ->get();

        $gallery = DB::table('clinic_gallery')
            ->join('clinics', 'clinics.id', 'clinic_gallery.clinic_id')
            ->select('clinic_gallery.file_name')
            ->where('clinic_gallery.clinic_id', $id)
            ->get();

        $modernMethod = DB::table('family_plan_type_subcategory')
            ->join('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id')
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->get();

        $permanentMethod = DB::table('family_plan_type_subcategory')
            ->join('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id')
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->get();

        $naturalMethod = DB::table('family_plan_type_subcategory')
            ->join('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id')
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->get();

        return view('admin.providerManagement.editPage', ['provider' => $provider, 'galleries' => $gallery, 'modernMethod' => $modernMethod, 'naturalMethod' => $naturalMethod, 'permanentMethod' => $permanentMethod]);
    }

    public function updateProvider(Request $requests)
    {
        $request = request()->all();
        ClinicHours::where('clinic_id', $request['clinic_id'])->delete();
        for ($clinic_hours = 0;$clinic_hours < 7;$clinic_hours++) {
            if (isset($request['days'][$clinic_hours])) {
                ClinicHours::create([
                    'clinic_id' => $request['clinic_id'],
                    'id_value' => $clinic_hours,
                    'days' => $request['days'][$clinic_hours],
                    'froms' => $request['from'][$clinic_hours],
                    'tos' => $request['to'][$clinic_hours],
                    'is_checked' => 1,
                ]);
            }
        }
        if ($requests->file('gallery') !== null) {
            ClinicGallery::where('clinic_id', $request['clinic_id'])->delete();

            for ($files = 0;$files <= 4;$files++) {
                $icon = $requests->file('gallery')[$files];
                $destination = public_path('/uploads');
                $icon->move($destination, $icon->getClientOriginalName());
                $icon_url = url('uploads/'.$icon->getClientOriginalName());
                ClinicGallery::create([
                    'file_name' => $icon->getClientOriginalName(),
                    'clinic_id' => $request['clinic_id'],
                    'file_url' => $icon_url,
                    'value_id' => $files,
                ]);
            }
        }
        for ($eee = 0;$eee <= 10000;$eee++) {
            if (isset($request['services'][$eee])) {
                PaidServices::where('clinic_id', $request['clinic_id'])->delete();
                PaidServices::create([
                    'service_id' => $request['services'][$eee],
                    'clinic_id' => $request['clinic_id'],
                    'is_checked' => 1,
                ]);
            }
        }
        Clinics::where('id', $request['clinic_id'])->update([
            'clinic_name' => $request['clinic_name'],
            'street_address' => $request['street_address'],
            'description' => $request['description'],
            'contact_number' => $request['contact_number'],
            'city' => $request['city'],
            'municipality' => $request['municipality'],
            'province' => $request['province'],
            'email' => $request['email'],
            'type' => $request['type'],
            'paid_service' => $request['paid'],
            'philhealth_accredited_1' => $request['philhealth_accredited_1'],
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
            'pic' => 'required|mimes:png,jpeg,jpg|max:5000',
            'clinic_name' => 'required',
            'contact_number' => 'required',
            'email' => 'required',
            'street_address' => 'required',
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
        $user = DB::table('clinics')->where('clinic_name', $request['clinic_name'])->pluck('id');
        session(['id' => $user[0]]);
        return view('admin.providerManagement.createProviderSecondPage');
    }

    public function storeSecondPage(Request $requests)
    {
        $request = request()->all();
        for ($files = 0;$files <= 4;$files++) {
            if (isset($requests->file('files')[$files])) {
                $icon = $requests->file('files')[$files];
                $destination = public_path('/uploads');
                $icon->move($destination, $icon->getClientOriginalName());
                $icon_url = url('uploads/'.$icon->getClientOriginalName());
                ClinicGallery::create([
                    'file_name' => $icon->getClientOriginalName(),
                    'clinic_id' => session('id'),
                    'file_url' => $icon_url,
                    'is_checked' => 1,
                    'value_id' => $files,
                ]);
            }
        }
        for ($clinic_hours = 0;$clinic_hours < 7;$clinic_hours++) {
            if (isset($request['days'][$clinic_hours])) {
                ClinicHours::create([
                    'clinic_id' => session('id'),
                    'id_value' => $clinic_hours,
                    'days' => $request['days'][$clinic_hours],
                    'froms' => $request['from'][$clinic_hours],
                    'tos' => $request['to'][$clinic_hours],
                    'is_checked' => 1,
                ]);
            }
        }
        return redirect()->action('Admin\ProviderManagementController@createThirdPage');
    }

    public function storeThirdPage()
    {
        $request = request()->all();
        for ($service = 0; $service <= 10000; $service++) {
            if (isset($request['service'][$service])) {
                PaidServices::create([
                    'service_id' => $request['service'][$service],
                    'clinic_id' => session('id'),
                    'is_checked' => 1,
                ]);
            }
        }

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
        // Clinics::where('id', session('id'))->update([
        //     'paid_service' => $request['paid'],
        // ]);

        Clinics::where('id', session('id'))->update(['is_approve' => 1]);

        return redirect('/provider/profile/'.session('id'));
    }
}
