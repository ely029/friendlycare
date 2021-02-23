<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\ClinicGallery;
use App\ClinicHours;
use App\Clinics;
use App\ClinicService;
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
        ClinicHours::where('clinic_id', $request['clinic_id'])->delete();
        ClinicService::where('clinic_id', $request['clinic_id'])->delete();
        PaidServices::where('clinic_id', $request['clinic_id'])->delete();
        $this->validateClinicHours($request);
        for ($eee = 0;$eee <= 10000;$eee++) {
            if (isset($request['services'][$eee])) {
                PaidServices::create([
                    'service_id' => $request['services'][$eee],
                    'clinic_id' => $request['clinic_id'],
                    'is_checked' => 1,
                ]);
            }
        }
        for ($eee = 0;$eee <= 10000;$eee++) {
            if (isset($request['avail_services'][$eee])) {
                ClinicService::create([
                    'service_id' => $request['avail_services'][$eee],
                    'clinic_id' => $request['clinic_id'],
                    'is_checked' => 1,
                ]);
            }
        }
        $methods = new FamilyPlanTypeSubcategories();
        $data = $methods->getUncheckedServices($request['clinic_id']);
        foreach ($data as $datas) {
            ClinicService::create([
                'service_id' => $datas->id,
                'clinic_id' => $request['clinic_id'],
                'is_checked' => 0,
            ]);
        }

        $datas = $methods->getUncheckedPaidServices($request['clinic_id']);
        foreach ($datas as $datas) {
            PaidServices::create([
                'service_id' => $datas->id,
                'clinic_id' => $request['clinic_id'],
                'is_checked' => 0,
            ]);
        }
        $request['region_id_string'] = $request['region'];
        $request['city_id_string'] = $request['city'];
        $request['province_id_string'] = $request['province'];
        $request['barangay_id_string'] = $request['barangay'];
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
        ProviderNotifications::create([
            'title' => 'Clinic Information are updated',
            'message' => 'Your clinic had updated some of the information.',
            'clinic_id' => $request['clinic_id'],
            'type' => 'Update',
            'booking_id' => 0,
            'status' => 0,
        ]);
        $this->pushNotification($request['clinic_id']);
        return redirect('/provider/list');
    }

    public function pushNotification($id)
    {
        $users = DB::table('users')->select('users.fcm_notification_key')
            ->leftJoin('staffs', 'staffs.user_id', 'users.id')
            ->where('users.fcm_notification_key', '<>', null)
            ->where('staffs.clinic_id', $id)->orderBy('users.id', 'desc')->get();
        foreach ($users as $user) {
            $fcmurl = 'https://fcm.googleapis.com/fcm/send';
            $token = $user->fcm_notification_key;
            $notification = [
                'title' => 'Clinic Information',
                'body' => 'The Clinic information are updated',
                'icon' => 'myIcon',
                'sound' => 'defaultSound',
                'priority' => 'high',
                'contentAvailable' => true,
            ];
            $extraNotifications = ['message' => $notification, 'moredata' => 'bb'];
            $fcmNotification = [
                'to' => $token,
                'notification' => $notification,
                'data' => $extraNotifications,
            ];
            $headers = [
                'Authorization: key='.\Config::get('boilerplate.firebase.server_key').'',
                'Content-Type: application/json',
            ];
            $chh = curl_init();
            curl_setopt($chh, CURLOPT_URL, $fcmurl);
            curl_setopt($chh, CURLOPT_POST, true);
            curl_setopt($chh, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($chh, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chh, CURLOPT_SSL_VERIFYPEER, $headers);
            curl_setopt($chh, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($chh);
            curl_close($chh);
            return $result;
        }
    }

    public function deleteProvider($id)
    {
        $email = DB::table('clinics')->select('email')->where('id', $id)->pluck('email');
        Mail::send('email.patient.provider.deactivation', [], function ($mail) use ($email) {
            $mail->from('notifications@friendlycare.com');
            $mail->to($email[0], 'Provider')->subject('Account Deactivated');
        });
        Clinics::where('id', $id)->delete();
        ClinicHours::where('clinic_id', $id)->delete();

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
        for ($clinic_hours = 0;$clinic_hours < 7;$clinic_hours++) {
            if (isset($request['days'][$clinic_hours])) {
                $this->validateClinicHours2($clinic_hours, $request);
            } else {
                $days = ['days' => [0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday']];
                ClinicHours::create([
                    'clinic_id' => session('id'),
                    'id_value' => $clinic_hours,
                    'days' => $days['days'][$clinic_hours],
                    'froms' => null,
                    'tos' => null,
                    'is_checked' => 0,
                ]);
            }
        }
        return redirect()->action('Admin\ProviderManagementController@createThirdPage');
    }

    public function storeThirdPage()
    {
        $request = request()->all();
        $methods = new FamilyPlanTypeSubcategories();
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
            if (isset($request['services'][$service])) {
                PaidServices::create([
                    'service_id' => $request['services'][$service],
                    'clinic_id' => session('id'),
                    'is_checked' => 1,
                ]);
            }
        }
        $data = $methods->getUncheckedPaidServices(session('id'));
        foreach ($data as $datas) {
            PaidServices::create([
                'service_id' => $datas->id,
                'clinic_id' => session('id'),
                'is_checked' => 0,
            ]);
        }

        for ($modern = 0;$modern <= 1000;$modern++) {
            if (isset($request['available_service'][$modern])) {
                ClinicService::create([
                    'service_id' => $request['available_service'][$modern],
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
        Clinics::where('id', session('id'))->update([
            'paid_service' => $request['paid'],
        ]);
        for ($permanent = 0;$permanent <= 1000;$permanent++) {
            if (isset($request['permanent'][$permanent])) {
                ClinicService::create([
                    'service_id' => $request['permanent'][$permanent],
                    'clinic_id' => session('id'),
                    'is_checked' => 1,
                ]);
            }
        }

        $datas1 = $methods->getUncheckedServices(session('id'));
        foreach ($datas1 as $data) {
            ClinicService::create([
                'service_id' => $data->id,
                'clinic_id' => session('id'),
                'is_checked' => 0,
            ]);
        }
        Clinics::where('id', session('id'))->update(['is_approve' => 1]);

        return redirect('/provider/profile/'.session('id'));
    }

    public function ratingPerPatient($id)
    {
        $ratings = new Ratings();
        $countPatientRatings = $ratings->viewPageCountRatings($id);
        $details = $ratings->viewPageDetails($id);
        $clinic_name = DB::table('clinics')
            ->leftJoin('ratings', 'ratings.clinic_id', 'clinics.id')
            ->select('clinics.clinic_name', 'clinics.contact_number', 'clinics.email', 'clinics.photo_url')
            ->where('clinics.id', $id)
            ->distinct('clinics.clinic_name')
            ->get();

        return view('admin.providerManagement.reviews', ['details' => $details, 'clinic_name' => $clinic_name, 'patientCount' => $countPatientRatings]);
    }

    public function enableProvider()
    {
        $request = request()->all();
        $email = DB::table('clinics')->select('email')->where('id', $request['id'])->pluck('email');
        Mail::send('email.patient.provider.enabled', [], function ($mail) use ($email) {
            $mail->from('notifications@friendlycare.com');
            $mail->to($email[0], 'Provider')->subject('Account Enabled');
        });
        $request = request()->all();
        Clinics::where('id', $request['id'])->update([
            'is_close' => 0,
        ]);

        ProviderNotifications::create([
            'title' => 'Clinic is activated',
            'message' => 'Your clinic is activated',
            'clinic_id' => $request['id'],
            'type' => 'Update',
            'booking_id' => 0,
            'status' => 1,
        ]);
    }

    public function disableProvider()
    {
        $request = request()->all();
        $email = DB::table('clinics')->select('email')->where('id', $request['id'])->pluck('email');
        Mail::send('email.patient.provider.disabled', [], function ($mail) use ($email) {
            $mail->from('notifications@friendlycare.com');
            $mail->to($email[0], 'Provider')->subject('Account Disabled');
        });
        $request = request()->all();
        Clinics::where('id', $request['id'])->update([
            'is_close' => 1,
        ]);

        ProviderNotifications::create([
            'title' => 'Clinic is deactivated',
            'message' => 'Your clinic is deactivated',
            'clinic_id' => $request['id'],
            'type' => 'Update',
            'booking_id' => 0,
            'status' => 1,
        ]);
    }

    public function province()
    {
        $request = request()->all();
        return DB::table('refprovince')->select('provDesc as province_description', 'provCode as province_code')->where('regCode', $request['region'])->get();
    }

    public function city()
    {
        $request = request()->all();
        return DB::table('refcitymun')->select('citymunDesc as city_municipality_description', 'citymunCode as city_municipality_code')->where('provCode', $request['province'])->get();
    }
    public function barangay()
    {
        $request = request()->all();
        return DB::table('refbrgy')->select('brgyCode as barangay_code', 'brgyDesc as barangay_description')->where('citymuncode', $request['barangay'])->get();
    }

    public function galleryUpload(Request $request)
    {
        $icon = $request->file('file');
        $destination = public_path('/uploads');
        $icon[0]->move($destination, $icon[0]->getClientOriginalName());
        $icon_url = url('uploads/'.$icon[0]->getClientOriginalName());
        ClinicGallery::create([
            'file_name' => $icon[0]->getClientOriginalName(),
            'clinic_id' => $request['clinic'],
            'file_url' => $icon_url,
        ]);
    }

    public function deleteGallery($id, $clinicId)
    {
        ClinicGallery::where('id', $id)->delete();
        return redirect('/provider/edit/'.$clinicId);
    }
    public function profPicUpload(Request $request)
    {
        $request = request()->all();
        $icon = $request['pic'];
        $destination = public_path('assets/app/img/');
        $icon_url = url('assets/app/img/'.$icon->getClientOriginalName());
        $icon->move($destination, $icon->getClientOriginalName());
        return response()->json($icon_url);
    }
    private function validateClinicHours($request)
    {
        for ($clinic_hours = 0;$clinic_hours < 7;$clinic_hours++) {
            if (isset($request['days'][$clinic_hours])) {
                $this->validateClinicHours1($clinic_hours, $request);
            } else {
                $days = ['days' => [0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday']];
                ClinicHours::create([
                    'clinic_id' => $request['clinic_id'],
                    'id_value' => $clinic_hours,
                    'days' => $days['days'][$clinic_hours],
                    'froms' => null,
                    'tos' => null,
                    'is_checked' => 0,
                ]);
            }
        }
    }

    private function validateClinicHours1($clinic_hours, $request)
    {
        if ($request['from'][$clinic_hours] !== null && $request['to'][$clinic_hours] !== null) {
            ClinicHours::create([
                'clinic_id' => $request['clinic_id'],
                'id_value' => $clinic_hours,
                'days' => $request['days'][$clinic_hours],
                'froms' => $request['from'][$clinic_hours],
                'tos' => $request['to'][$clinic_hours],
                'is_checked' => 1,
            ]);
        } else {
            ClinicHours::create([
                'clinic_id' => $request['clinic_id'],
                'id_value' => $clinic_hours,
                'days' => $request['days'][$clinic_hours],
                'froms' => null,
                'tos' => null,
                'is_checked' => 0,
            ]);
        }
    }

    private function validateClinicHours2($clinic_hours, $request)
    {
        if ($request['from'][$clinic_hours] !== null && $request['to'][$clinic_hours] !== null) {
            ClinicHours::create([
                'clinic_id' => session('id'),
                'id_value' => $clinic_hours,
                'days' => $request['days'][$clinic_hours],
                'froms' => $request['from'][$clinic_hours],
                'tos' => $request['to'][$clinic_hours],
                'is_checked' => 1,
            ]);
        } else {
            ClinicHours::create([
                'clinic_id' => session('id'),
                'id_value' => $clinic_hours,
                'days' => $request['days'][$clinic_hours],
                'froms' => null,
                'tos' => null,
                'is_checked' => 0,
            ]);
        }
    }
}
