<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Classes\PushNotifications;
use App\ClinicGallery;
use App\ClinicHours;
use App\Clinics;
use App\ClinicService;
use App\ClinicTime;
use App\FamilyPlanTypeSubcategories;
use App\Http\Controllers\Controller;
use App\PaidServices;
use App\ProviderNotifications;
use App\Ratings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class ProviderManagementController extends Controller
{
    public function index()
    {
        $clinics = new Clinics();
        $users = $clinics->indexPage();
        return view('admin.providerManagement.index', ['clinics' => $users]);
    }
    public function createFirstPage()
    {
        $data = DB::table('refregion')->select('regCode as region_code', 'regDesc as region_description')->get();
        return view('admin.providerManagement.createProviderFirstPage', ['region' => $data]);
    }

    public function createSecondPage()
    {
        return view('admin.providerManagement.createProviderSecondPage');
    }

    public function createThirdPage()
    {
        $modernMethod = DB::table('family_plan_type_subcategory')
            ->select('name', 'id', 'short_name')
            ->where('family_plan_type_id', 1)
            ->where('is_approve', 1)
            ->get();

        $permanentMethod = DB::table('family_plan_type_subcategory')
            ->select('name', 'id', 'short_name')
            ->where('family_plan_type_id', 2)
            ->where('is_approve', 1)
            ->get();

        $naturalMethod = DB::table('family_plan_type_subcategory')
            ->select('name', 'id', 'short_name')
            ->where('family_plan_type_id', 3)
            ->where('is_approve', 1)
            ->get();
        return view('admin.providerManagement.createProviderThirdPage', ['modernMethod' => $modernMethod, 'permanentMethod' => $permanentMethod, 'naturalMethod' => $naturalMethod]);
    }

    public function editProviderInformation($id)
    {
        $clinics = new Clinics();
        $ratings = new Ratings();
        $fpm = new FamilyPlanTypeSubcategories();
        $paidService = new PaidServices();
        $clinicGallery = new ClinicGallery();
        $clinicHours = new ClinicHours();
        $provider = $clinics->editProviderInformation($id);
        $modernMethod = $fpm->providerInformationModern($id);
        $ratings = $ratings->getRatingsProviderInformation($id);
        $permanentMethod = $fpm->providerInformationPermanent($id);
        $naturalMethod = $fpm->providerInformationNatural($id);
        $paidServices = $paidService->providerInformationPaidService($id);
        $staff = DB::table('staffs')
            ->join('users', 'users.id', 'staffs.user_id')
            ->select('users.first_name', 'users.last_name')
            ->where('staffs.clinic_id', $id)
            ->get();
        $clinicHours = $clinicHours->providerInformationPage($id);
        $gallery = $clinicGallery->galleryEditProviderInformation($id);
        $countPatientRatings = DB::table('ratings')
            ->select('patient_id')
            ->where('clinic_id', $id)
            ->count();

        return view('admin.providerManagement.editProviderInformation', ['provider' => $provider, 'modernMethod' => $modernMethod, 'permanentMethod' => $permanentMethod, 'naturalMethod' => $naturalMethod, 'staffs' => $staff, 'paidServices' => $paidServices, 'clinicHours' => $clinicHours, 'galleries' => $gallery, 'ratings' => $ratings, 'countPatient' => $countPatientRatings ]);
    }

    public function editPage($id)
    {
        $clinics = new Clinics();
        $clinicGallery = new ClinicGallery();
        $paidService = new PaidServices();
        $clinicHours = new ClinicHours();
        $clinicService = new ClinicService();
        $provider = $clinics->getInformation($id);
        $gallery = $clinicGallery->editPage($id);
        $paid_modernMethod = $paidService->editPageModern($id);
        $paid_permanentMethod = $paidService->editPagePermanent($id);
        $paid_naturalMethod = $paidService->editPageNatural($id);
        $clinicHours = $clinicHours->editPage($id);
        $service_modern = $clinicService->editPageModern($id);
        $service_permanent = $clinicService->editPagePermanent($id);
        $service_natural = $clinicService->editPageNatural($id);

        $data = DB::table('refregion')->select('regCode as region_code', 'regDesc as region_description')->get();

        return view('admin.providerManagement.editPage', ['data' => $data, 'service_natural' => $service_natural, 'service_permanent' => $service_permanent, 'service_modern' => $service_modern, 'provider' => $provider, 'galleries' => $gallery, 'modernMethod' => $paid_modernMethod, 'naturalMethod' => $paid_naturalMethod, 'permanentMethod' => $paid_permanentMethod, 'clinic_hours' => $clinicHours]);
    }

    public function updateProvider()
    {
        $request = request()->all();
        $clinics = new Clinics();
        $paidService = new PaidServices();
        $clinicService = new ClinicService();
        $providerNotification = new ProviderNotifications();
        $pushNotification = new PushNotifications();
        $clinicTime = new ClinicTime();
        ClinicService::where('clinic_id', $request['clinic_id'])->delete();
        PaidServices::where('clinic_id', $request['clinic_id'])->delete();
        for ($eee = 0; $eee <= 6; $eee++) {
            $days = ! isset($request['days'][$eee]) ? '' : $request['days'][$eee];
            if ($request['from'][$eee] === null && $request['to'][$eee] === null) {
                ClinicHours::where('clinic_id', $request['clinic_id'])->where('days', $days)->update([
                    'froms' => '',
                    'tos' => '',
                    'is_checked' => 0,
                ]);
            }
        }
        $this->validateClinicHours($request);
        for ($eee = 0;$eee <= 10000;$eee++) {
            if (isset($request['services'][$eee])) {
                $paidService->updatePaidService($request, $eee);
            }
        }
        for ($eee = 0;$eee <= 10000;$eee++) {
            if (isset($request['avail_services'][$eee])) {
                $clinicService->updateClinicService($request, $eee);
            }
        }
        $methods = new FamilyPlanTypeSubcategories();
        $data = $methods->getUncheckedServices($request['clinic_id']);
        foreach ($data as $datas) {
            $clinicService->createUncheckedService1($datas, $request);
        }

        $datas = $methods->getUncheckedPaidServices($request['clinic_id']);
        foreach ($datas as $datas) {
            $paidService->createUncheckedPaidServices($datas, $request);
        }
        $request['region_id_string'] = $request['region'] ?? null;
        $request['city_id_string'] = $request['city'] ?? null;
        $request['province_id_string'] = $request['province'] ?? null;
        $request['barangay_id_string'] = $request['barangay'] ?? null;
        $region = DB::table('refregion')->select('regDesc')->where('regCode', $request['region'])->pluck('regDesc');
        $province = DB::table('refprovince')->select('provDesc')->where('provCode', $request['province'] ?? '')->pluck('provDesc');
        $city = DB::table('refcitymun')->select('citymundesc')->where('citymunCode', $request['city'] ?? '')->pluck('citymundesc');
        $barangay = DB::table('refbrgy')->select('brgyDesc')->where('brgyCode', $request['barangay'] ?? '')->pluck('brgyDesc');
        $request['region'] = $region[0] ?? '';
        $request['province'] = $province[0] ?? '';
        $request['city'] = $city[0] ?? '';
        $request['barangay'] = $barangay[0] ?? '';
        if ($request['pic_url'] === null) {
            $clinics->updateProviderWithoutProfilePhoto($request);
        } else {
            $clinics->updateProviderWithProfilePhoto($request);
        }
        ClinicTime::where('clinic_id', $request['clinic_id'])->delete();
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        for ($hhh = 0; $hhh < 7; $hhh++) {
            $clinicTime->CreateTimeDuration($request['clinic_id'], $days[$hhh]);
        }
        $pushNotification->patientStaffPushNotification($request['clinic_id'], 'Clinic Update Information', 'Your Clinic is updated an information');
        $providerNotification->clinicUpdateNotification($request);
        return redirect('/provider/list');
    }
    public function deleteProvider($id)
    {
        $email = DB::table('clinics')->select('email')->where('id', $id)->pluck('email');
        Mail::send('email.patient.provider.deactivation', [], function ($mail) use ($email) {
            $mail->from('notifications@friendlycare.com');
            $mail->to($email[0], 'Provider')->subject('Account Deactivated');
        });
        DB::delete('delete from clinics where id = ?', [$id]);
        DB::delete('delete from clinic_hours where clinic_id = ?', [$id]);
        return redirect('provider/list');
    }

    public function storeFirstPage()
    {
        $validator = \Validator::make(request()->all(), [
            'pic' => 'required|mimes:png,jpeg,jpg|max:5000',
            'clinic_name' => 'required',
            'contact_number' => 'required',
            'email' => 'required',
            'street_address' => 'required',
            'type' => 'required',
            'region' => 'required',
            'city' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('provider/create/1')
                ->withErrors($validator)
                ->withInput();
        }

        $request = request()->all();
        $request['profession'] = 'N/A';
        $request['training'] = 'N/A';
        $icon_url = $request['pic_url'];
        $request['photo_url'] = $icon_url;
        $request['region_id_string'] = $request['region'] ?? null;
        $request['city_id_string'] = $request['city'] ?? null;
        $request['province_id_string'] = $request['province'] ?? null;
        $request['barangay_id_string'] = $request['barangay'] ?? null;
        $region = DB::table('refregion')->select('regDesc')->where('regCode', $request['region'])->pluck('regDesc');
        $province = DB::table('refprovince')->select('provDesc')->where('provCode', $request['province'] ?? '')->pluck('provDesc');
        $city = DB::table('refcitymun')->select('citymundesc')->where('citymunCode', $request['city'] ?? '')->pluck('citymundesc');
        $barangay = DB::table('refbrgy')->select('brgyDesc')->where('brgyCode', $request['barangay'] ?? '')->pluck('brgyDesc');
        $request['region'] = $region[0] ?? null;
        $request['province'] = $province[0] ?? null;
        $request['city'] = $city[0] ?? null;
        $request['barangay'] = $barangay[0] ?? null;
        Clinics::create($request);
        $user = DB::table('clinics')->where('clinic_name', $request['clinic_name'])->pluck('id');
        session(['id' => $user[0]]);
        return view('admin.providerManagement.createProviderSecondPage');
    }

    public function storeSecondPage()
    {
        $request = request()->all();
        $clinicTime = new ClinicTime();
        $clinicHours = new ClinicHours();
        ClinicHours::where('clinic_id', session('id'))->delete();
        for ($clinic_hours = 0;$clinic_hours < 7;$clinic_hours++) {
            if (isset($request['days'][$clinic_hours])) {
                ClinicHours::create([
                    'clinic_id' => session('id'),
                    'days' => ucfirst($request['days'][$clinic_hours]),
                    'froms' => $request['from'][$clinic_hours],
                    'tos' => $request['to'][$clinic_hours],
                    'is_checked' => 1,
                ]);
            } else {
                $days = ['days' => [0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday']];
                $clinicHours->createEmptyClinicHours($clinic_hours, $days);
            }
        }
        ClinicTime::where('clinic_id', session('id'))->delete();
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        for ($hhh = 0; $hhh < 7; $hhh++) {
            $clinicTime->CreateTimeDuration(session('id'), $days[$hhh]);
        }
        return redirect()->action('Admin\ProviderManagementController@createThirdPage');
    }

    public function storeThirdPage()
    {
        $request = request()->all();
        $methods = new FamilyPlanTypeSubcategories();
        $clinicService = new ClinicService();
        $paidService = new PaidServices();
        $validator = \Validator::make(request()->all(), [
            'available_service' => 'required',
            'paid' => 'required',
        ]);
        $request['role_id'] = 2;
        if ($validator->fails()) {
            return redirect('provider/create/3')
                ->withErrors($validator)
                ->withInput();
        }
        for ($service = 0; $service <= 10000; $service++) {
            if (isset($request['paid_services'][$service])) {
                $paidService->createUncheckedPaidServices1($request, $service);
            }
        }
        $data = $methods->getUncheckedPaidServices(session('id'));
        foreach ($data as $datas) {
            $paidService->createPaidServices2($datas);
        }

        for ($modern = 0;$modern <= 1000;$modern++) {
            if (isset($request['available_service'][$modern])) {
                $clinicService->createModernClinicService($request, $modern);
            }
        }
        for ($natural = 0;$natural <= 1000;$natural++) {
            if (isset($request['natural'][$natural])) {
                $clinicService->createNaturalClinicService($request, $natural);
            }
        }
        Clinics::where('id', session('id'))->update([
            'paid_service' => $request['paid'],
        ]);
        for ($permanent = 0;$permanent <= 1000;$permanent++) {
            if (isset($request['permanent'][$permanent])) {
                $clinicService->createPermanentClinicService($request, $permanent);
            }
        }

        $datas1 = $methods->getUncheckedServices(session('id'));
        foreach ($datas1 as $data) {
            $clinicService->createUncheckedService($data);
        }
        Clinics::where('id', session('id'))->update(['is_approve' => 1]);

        return redirect('/provider/profile/'.session('id'));
    }

    public function ratingPerPatient($id)
    {
        $ratings = new Ratings();
        $clinic = new Clinics();
        $countPatientRatings = $ratings->viewPageCountRatings($id);
        $details = $ratings->viewPageDetails($id);
        $clinic_name = $clinic->clinicName($id);

        return view('admin.providerManagement.reviews', ['details' => $details, 'clinic_name' => $clinic_name, 'patientCount' => $countPatientRatings]);
    }

    public function enableProvider()
    {
        $request = request()->all();
        $providerNotification = new ProviderNotifications();
        $pushNotification = new PushNotifications();
        $email = DB::table('clinics')->select('email')->where('id', $request['id'])->pluck('email');
        Mail::send('email.patient.provider.enabled', [], function ($mail) use ($email) {
            $mail->from('notifications@friendlycare.com');
            $mail->to($email[0], 'Provider')->subject('Account Enabled');
        });
        $request = request()->all();
        Clinics::where('id', $request['id'])->update([
            'is_close' => 0,
        ]);
        $pushNotification->patientStaffPushNotification($request['id'], 'Clinic Enabled', 'Your Clinic is enabled');
        $providerNotification->accountDisabledNotification($request);
    }

    public function disableProvider()
    {
        $request = request()->all();
        $providerNotification = new ProviderNotifications();
        $pushNotification = new PushNotifications();
        $email = DB::table('clinics')->select('email')->where('id', $request['id'])->pluck('email');
        Mail::send('email.patient.provider.disabled', [], function ($mail) use ($email) {
            $mail->from('notifications@friendlycare.com');
            $mail->to($email[0], 'Provider')->subject('Account Disabled');
        });
        $request = request()->all();
        Clinics::where('id', $request['id'])->update([
            'is_close' => 1,
        ]);
        $pushNotification->patientStaffPushNotification($request['id'], 'Clinic Disabled', 'Your Clinic is disabled');
        $providerNotification->accountEnabledNotification($request);
    }

    public function province()
    {
        $request = request()->all();
        return DB::table('refprovince')->select('provDesc as province_description', 'provCode as province_code')->orWhere('regCode', $request['region'])->get();
    }

    public function getProvince()
    {
        $request = request()->all();
        return DB::table('refprovince')->select('provDesc as province_description', 'provCode as province_code')->where('provCode', $request['selected_province'])->get();
    }

    public function getCity()
    {
        $request = request()->all();
        return DB::table('refcitymun')->select('citymunDesc as city_description', 'citymunCode as city_code')->where('citymunCode', $request['selected_city'])->get();
    }

    public function getBarangay()
    {
        $request = request()->all();
        return DB::table('refbrgy')->select('brgyDesc as brgy_description', 'brgyCode as barangay_code')->where('brgyCode', $request['selected_barangay'])->get();
    }

    public function city()
    {
        $request = request()->all();
        return DB::table('refcitymun')->select('citymunDesc as city_municipality_description', 'citymunCode as city_municipality_code')->where('provCode', $request['province'])->get();
    }
    public function barangay()
    {
        $clinic = new Clinics();
        $request = request()->all();
        if ($request['barangay'] === '133911') {
            return $clinic->getBarangayManila();
        }
        return DB::table('refbrgy')->select('brgyCode as barangay_code', 'brgyDesc as barangay_description')->where('citymuncode', $request['barangay'])->get();
    }

    public function galleryUpload(Request $request)
    {
        $clinicGallery = new ClinicGallery();
        $icon = $request->file('file');
        $icon[0]->storeAs('public', $icon[0]->getClientOriginalName());
        $icon_url = url('storage/'.$icon[0]->getClientOriginalName());
        $clinicGallery->createGallery($icon, $request, $icon_url);
    }

    public function deleteGallery($id, $clinicId)
    {
        ClinicGallery::where('id', $id)->delete();
        return redirect('/provider/edit/'.$clinicId);
    }

    public function profPicUpload(Request $request)
    {
        $icon = $request->file('pic');
        $icon->storeAs('public', $icon->getClientOriginalName());
        return response()->json(url('storage/'.$icon->getClientOriginalName()));
    }
    private function validateClinicHours($request)
    {
        for ($clinic_hours = 0;$clinic_hours < 7;$clinic_hours++) {
            if (isset($request['days'][$clinic_hours])) {
                ClinicHours::where('clinic_id', $request['clinic_id'])->where('days', $request['days'][$clinic_hours])->update([
                    'froms' => $request['from'][$clinic_hours],
                    'tos' => $request['to'][$clinic_hours],
                    'is_checked' => 1,
                ]);
            }
            // } else {
            //     // $days = ['days' => [0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday']];
            //     // $clinicHours = new ClinicHours();
            //     // $clinicHours->createUncheckedClinicHours($request, $clinic_hours, $days);
            // }
        }
    }

    // private function validateClinicHours1($clinic_hours, $request)
    // {
    //     $clinicHours = new ClinicHours();
    //     if ($request['from'][$clinic_hours] !== null && $request['to'][$clinic_hours] !== null) {
    //         $clinicHours->createCheckedClinicHours($request, $clinic_hours);
    //      }
    //      //else {
    //     //     $clinicHours->createClinicHourswithoutTime($request, $clinic_hours);
    //     // }
    // }
}
