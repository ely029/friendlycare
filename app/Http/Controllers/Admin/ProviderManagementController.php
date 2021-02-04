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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class ProviderManagementController extends Controller
{
    public function index()
    {
        $users = DB::table('clinics')
            ->leftJoin('staffs', 'staffs.clinic_id', 'clinics.id')
            ->leftJoin('ratings', 'ratings.clinic_id', 'clinics.id')
            ->leftJoin('ratings_details', 'ratings_details.rating_id', 'ratings.id')
            ->select('clinics.email', 'clinics.type', 'clinics.id', 'clinics.clinic_name', DB::raw('count(staffs.id) as number_staff'), DB::raw('avg(ratings_details.ratings) as avg'))
            ->where('clinics.email', '<>', 'null')
            ->where('clinics.is_approve', '<>', 0)
            ->groupBy(['clinics.email', 'clinics.type', 'clinics.id', 'clinics.clinic_name'])
            ->get();
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
                'clinics.is_close',
                'clinics.philhealth_accredited_1',
                'clinics.photo_url',
           )
            ->where(['clinics.id' => $id, 'clinics.is_approve' => 1])
            ->whereNotNull('clinics.clinic_name')
            ->get();

        $modernMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('clinic_service.is_checked', 1)
            ->get();

        $ratings = DB::table('ratings')
            ->join('ratings_details', 'ratings_details.rating_id', 'ratings.id')
            ->where('ratings.clinic_id', $id)
            ->avg('ratings_details.ratings');

        $permanentMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('clinic_service.is_checked', 1)
            ->get();

        $naturalMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name')
            ->where('clinic_service.clinic_id', $id)
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('clinic_service.is_checked', 1)
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

        $countPatientRatings = DB::table('ratings')
            ->select('patient_id')
            ->where('clinic_id', $id)
            ->count();

        return view('admin.providerManagement.editProviderInformation', ['provider' => $provider, 'modernMethod' => $modernMethod, 'permanentMethod' => $permanentMethod, 'naturalMethod' => $naturalMethod, 'staffs' => $staff, 'paidServices' => $paidServices, 'clinicHours' => $clinicHours, 'galleries' => $gallery, 'ratings' => $ratings, 'countPatient' => $countPatientRatings ]);
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
                'clinics.photo_url',
                'clinics.region',
                'clinics.region_id_string',
                'clinics.province_id_string',
                'clinics.barangay_id_string',
                'clinics.city_id_string',
                'clinics.province',
                'clinics.city',
                'clinics.barangay',
               )
            ->where('clinics.id', $id)
            ->get();

        $gallery = DB::table('clinic_gallery')
            ->join('clinics', 'clinics.id', 'clinic_gallery.clinic_id')
            ->select('clinic_gallery.file_name', 'clinics.id as clinic_id', 'clinic_gallery.file_url', 'clinic_gallery.id')
            ->where('clinic_gallery.clinic_id', $id)
            ->get();
        $paid_modernMethod = DB::table('family_plan_type_subcategory')
            ->join('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'family_plan_type_subcategory.short_name', 'paid_services.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('paid_services.clinic_id', $id)
            ->get();

        $paid_permanentMethod = DB::table('family_plan_type_subcategory')
            ->join('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'family_plan_type_subcategory.short_name', 'paid_services.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('paid_services.clinic_id', $id)
            ->get();

        $paid_naturalMethod = DB::table('family_plan_type_subcategory')
            ->join('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'family_plan_type_subcategory.short_name', 'paid_services.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('paid_services.clinic_id', $id)
            ->get();
        $clinicHours = DB::table('clinic_hours')
            ->select('is_checked', 'days', 'froms', 'tos', 'id_value')
            ->where('clinic_id', $id)
            ->get();

        $service_modern = DB::table('family_plan_type_subcategory as fpm')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'fpm.id')
            ->select('fpm.id', 'fpm.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $id)
            ->where('fpm.family_plan_type_id', 1)
            ->get();
        $service_permanent = DB::table('family_plan_type_subcategory as fpm')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'fpm.id')
            ->select('fpm.id', 'fpm.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $id)
            ->where('fpm.family_plan_type_id', 2)
            ->get();

        $service_natural = DB::table('family_plan_type_subcategory as fpm')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'fpm.id')
            ->select('fpm.id', 'fpm.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $id)
            ->where('fpm.family_plan_type_id', 3)
            ->get();

        $data = DB::table('refregion')->select('regCode as region_code', 'regDesc as region_description')->get();

        return view('admin.providerManagement.editPage', ['data' => $data, 'service_natural' => $service_natural, 'service_permanent' => $service_permanent, 'service_modern' => $service_modern, 'provider' => $provider, 'galleries' => $gallery, 'modernMethod' => $paid_modernMethod, 'naturalMethod' => $paid_naturalMethod, 'permanentMethod' => $paid_permanentMethod, 'clinic_hours' => $clinicHours]);
    }

    public function updateProvider()
    {
        $request = request()->all();
        ClinicHours::where('clinic_id', $request['clinic_id'])->delete();
        ClinicService::where('clinic_id', $request['clinic_id'])->delete();
        PaidServices::where('clinic_id', $request['clinic_id'])->delete();
        $this->validateClinicHours($request);
        $this->pushNotification($request['clinic_id']);
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
        Clinics::where('id', $request['clinic_id'])->update([
            'clinic_name' => $request['clinic_name'],
            'street_address' => $request['street_address'],
            'description' => $request['description'],
            'contact_number' => $request['contact_number'],
            'city' => $request['city'] ?? '',
            'province' => $request['province'] ?? '',
            'email' => $request['email'],
            'region' => $request['region'] ?? '',
            'type' => $request['type'],
            'paid_service' => $request['paid'],
            'barangay' => $request['barangay'],
            'barangay_id_string' => $request['barangay_id_string'],
            'region_id_string' => $request['region_id_string'] ?? '',
            'province_id_string' => $request['province_id_string'] ?? '',
            'city_id_string' => $request['city_id_string'] ?? '',
            'philhealth_accredited_1' => $request['philhealth_accredited_1'],
        ]);
        ProviderNotifications::create([
            'title' => 'Clinic Information are updated',
            'message' => 'Your clinic had updated some of the information.',
            'clinic_id' => $request['clinic_id'],
            'type' => 'Update',
            'booking_id' => 0,
            'status' => 0,
        ]);
        return redirect('/provider/list');
    }

    public function pushNotification($id)
    {
        $users = DB::table('users')->select('fcm_notification_key')
            ->leftJoin('staffs', 'staffs.user_id', 'users.id')
            ->where('staffs.clinic_id', $id)->get();
        foreach ($users as $user) {
            $fcmurl = 'https://fcm.googleapis.com/fcm/send';
            $token = $user->fcm_notification_key;
            $notification = [
                'title' => 'Provider Information',
                'body' => 'The Provider information are updated',
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
                'Authorization: key='.env('BP_FIREBASE_SERVER_KEY').'',
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
            'province' => 'required',
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
        $request['region_id_string'] = $request['region'];
        $request['city_id_string'] = $request['city'];
        $request['province_id_string'] = $request['province'];
        $request['barangay_id_string'] = $request['barangay'];
        $region = DB::table('refregion')->select('regDesc')->where('regCode', $request['region'])->pluck('regDesc');
        $province = DB::table('refprovince')->select('provDesc')->where('provCode', $request['province'] ?? '')->pluck('provDesc');
        $city = DB::table('refcitymun')->select('citymundesc')->where('citymunCode', $request['city'] ?? '')->pluck('citymundesc');
        $barangay = DB::table('refbrgy')->select('brgyDesc')->where('brgyCode', $request['barangay'] ?? '')->pluck('brgyDesc');
        $request['region'] = $region[0];
        $request['province'] = $province[0];
        $request['city'] = $city[0];
        $request['barangay'] = $barangay[0];
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
        $countPatientRatings = DB::table('ratings')
            ->select('patient_id')
            ->where('clinic_id', $id)
            ->count();
        $details = DB::table('ratings')
            ->leftJoin('users', 'users.id', 'ratings.patient_id')
            ->leftJoin('ratings_details', 'ratings_details.rating_id', 'ratings.id')
            ->select('ratings_details.id', DB::raw('REPLACE(users.name,SUBSTR(users.name,2,2),"*****") as dddd '), 'ratings_details.ratings', 'ratings.review')
            ->where('ratings.clinic_id', $id)
            ->get();

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
