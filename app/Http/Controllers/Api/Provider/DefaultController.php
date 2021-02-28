<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Provider;

use App\ClinicGallery;
use App\ClinicHours;
use App\Clinics;
use App\ClinicService;
use App\ClinicTime;
use App\FamilyPlanTypeSubcategories;
use App\Holiday;
use App\Http\Controllers\Controller;
use App\PaidServices;
use App\PatientTimeSlot;
use App\Staffs;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class DefaultController extends Controller
{
    public function login(Request $request)
    {
        $obj = json_decode($request->getContent(), true);

        if (\Auth::attempt(['email' => $obj['email'], 'password' => $obj['password'], 'role_id' => 4])) {
            $user = \Auth::user();
            User::where('id', $user['id'])->update([
                'fcm_notification_key' => $obj['token'],
            ]);
            return response([
                'login_success' => 'Login Successful',
                'id' => $user['id'],
            ]);
        }
        return response([
            'message' => 'Uh Oh! Your email/password isn\'t right. Please check and retry',
        ], 422);
    }

    public function resetPassword()
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'email' => 'required',
            'confirm_email' => 'required|same:email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $users = DB::table('users')->select('id')->where('email', $request['email'])->pluck('id');

        Mail::send('email.patient.account-reset', ['users' => $users[0]], function ($mail) use ($request) {
            $mail->from('no-reply@friendlycare.com');
            $mail->to($request['email'], 'Staff')->subject('Reset Password');
        });
        return response([
            'message' => 'Email sent successfully',
        ], 200);
    }

    public function getUsersById($id)
    {
        $users = DB::table('staffs')
            ->join('users', 'users.id', 'staffs.user_id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.professions', 'users.trainings', 'users.fcm_notification_key')
            ->where('staffs.user_id', $id)
            ->get();

        return response([
            'data' => $users,
        ]);
    }

    public function getUsersByClinics($id)
    {
        $users = DB::table('clinics')
            ->leftJoin('staffs', 'staffs.clinic_id', 'clinics.id')
            ->leftJoin('users', 'users.id', 'staffs.user_id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.professions', 'users.trainings', 'users.fcm_notification_key')
            ->where('clinics.id', $id)
            ->get();

        return response([
            'data' => $users,
        ]);
    }

    public function getAllStaff()
    {
        $users = DB::table('staffs')
            ->join('users', 'users.id', 'staffs.user_id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.professions', 'users.trainings')
            ->get();

        return response([
            'data' => $users,
        ]);
    }

    public function update($id)
    {
        $request = request()->all();
        User::where('id', $id)->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'professions' => $request['profession'],
            'trainings' => $request['training'],
        ]);

        $users = DB::table('staffs')
            ->join('users', 'users.id', 'staffs.user_id')
            ->select('users.first_name', 'users.last_name', 'users.email', 'users.professions', 'users.trainings')
            ->where('staffs.user_id', $id)
            ->get();

        return response([
            'users' => $users,
        ]);
    }

    public function providerInfo($id)
    {
        $user = Staffs::where('user_id', $id)->first();
        $provider = Clinics::where(['is_approve' => 1, 'id' => $user['clinic_id']])->get();

        return response([
            'data' => $provider,
        ]);
    }

    public function getDescription($id)
    {
        $description = DB::table('staffs')
            ->join('clinics', 'clinics.id', 'staffs.clinic_id')
            ->select('clinics.description')
            ->where('staffs.user_id', $id)
            ->get();

        return response([
            'data' => $description,
        ]);
    }

    public function updateDescription($id)
    {
        $request = request()->all();
        $clinic = Staffs::where('user_id', $id)->first();
        Clinics::where('id', $clinic['clinic_id'])->update([
            'description' => $request['description'],
        ]);

        $description = Clinics::where('id', $clinic['clinic_id'])->first();

        return response([
            'data' => $description['description'],
        ]);
    }

    public function getAllProviders()
    {
        $provider = Clinics::where('is_approve', 1)->get();

        return response([
            'data' => $provider,
        ]);
    }

    public function getAllProvidersById($id)
    {
        $provider = Clinics::where(['is_approve' => 1, 'id' => $id])->get();

        return response([
            'data' => $provider,
        ]);
    }

    public function getClinicHours($id)
    {
        $schedules = DB::table('clinics')
            ->leftJoin('staffs', 'staffs.clinic_id', 'clinics.id')
            ->leftJoin('clinic_hours', 'clinic_hours.clinic_id', 'clinics.id')
            ->select('clinic_hours.days', 'clinic_hours.froms', 'clinic_hours.tos')
            ->where('staffs.user_id', $id)
            ->get();

        return response([
            'name' => 'ClinicHours',
            'schedule' => $schedules,
        ]);
    }

    public function updateClinicHours($id)
    {
        $request = request()->all();

        $clinic = Staffs::where('user_id', $id)->pluck('clinic_id');
        if (isset($request['monday_label'])) {
            ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['monday_label']])->update([
                'froms' => $request['monday_froms'],
                'tos' => $request['monday_tos'],
            ]);
        }

        if (isset($request['tuesday_label'])) {
            ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['tuesday_label']])->update([
                'froms' => $request['tuesday_froms'],
                'tos' => $request['tuesday_tos'],
            ]);
        }

        if (isset($request['wednesday_label'])) {
            ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['wednesday_label']])->update([
                'froms' => $request['wednesday_froms'],
                'tos' => $request['wednesday_tos'],
            ]);
        }

        if (isset($request['thursday_label'])) {
            ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['thursday_label']])->update([
                'froms' => $request['thursday_froms'],
                'tos' => $request['thursday_tos'],
            ]);
        }

        if (isset($request['friday_label'])) {
            ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['friday_label']])->update([
                'froms' => $request['friday_froms'],
                'tos' => $request['friday_tos'],
            ]);
        }

        if (isset($request['saturday_label'])) {
            ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['saturday_label']])->update([
                'froms' => $request['saturday_froms'],
                'tos' => $request['saturday_tos'],
            ]);
        }

        if (isset($request['sunday_label'])) {
            ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['sunday_label']])->update([
                'froms' => $request['sunday_froms'],
                'tos' => $request['sunday_tos'],
            ]);
        }

        $schedules = DB::table('clinics')
            ->join('clinic_hours', 'clinic_hours.clinic_id', 'clinics.id')
            ->select('clinic_hours.days', 'clinic_hours.froms', 'clinic_hours.tos')
            ->where('clinics.id', $clinic[0])
            ->get();

        return response([
            'name' => 'ClinicHours',
            'schedule' => $schedules,
        ]);
    }

    public function getAllServices()
    {
        $fpm = new FamilyPlanTypeSubcategories();
        $modernMethod = $fpm->getAllServicesModernMethod();
        $permanentMethod = $fpm->getAllServicesPermanentMethod();
        $naturalMethod = $fpm->getAllServicesNaturalMethod();

        return response([
            'name' => 'Services',
            'permanentMethod' => $permanentMethod,
            'naturalMethod' => $naturalMethod,
            'modernMethod' => $modernMethod,
        ]);
    }

    public function getServices($id)
    {
        $users = Staffs::where('user_id', $id)->pluck('clinic_id');
        $fpm = new FamilyPlanTypeSubcategories();
        $modernMethod = $fpm->getServicesModernMethod($users);
        $permanentMethod = $fpm->getServicesPermanentMethod($users);
        $naturalMethod = $fpm->getServicesNaturalMethod($users);

        return response([
            'name' => 'Services',
            'permanentMethod' => $permanentMethod,
            'naturalMethod' => $naturalMethod,
            'modernMethod' => $modernMethod,
        ]);
    }

    public function updateServices($id, Request $requests)
    {
        $obj = json_decode($requests->getContent(), true);
        $methods = new FamilyPlanTypeSubcategories();
        $users = Staffs::where('user_id', $id)->pluck('clinic_id');
        ClinicService::where('clinic_id', $users[0])->delete();
        $count = count($obj['services']);
        for ($eee = 0;$eee <= $count; $eee++) {
            if (isset($obj['services'][$eee])) {
                ClinicService::create([
                    'clinic_id' => $users[0],
                    'service_id' => $obj['services'][$eee],
                    'is_checked' => 1,
                ]);
            }
        }
        $data = $methods->getUncheckedServices($users[0]);
        foreach ($data as $datas) {
            ClinicService::create([
                'service_id' => $datas->id,
                'clinic_id' => $users[0],
                'is_checked' => 0,
            ]);
        }

        $modernMethodWithoutClinic = $methods->modernMethodWithoutClinic();
        $permanentMethodWithoutClinic = $methods->permanentMethodWithoutClinic();
        $naturalMethodWithoutClinic = $methods->naturalMethodWithoutClinic();
        $modernMethod = $methods->modernMethodUpdateService($users);
        $permanentMethod = $methods->permanentMethodUpdateService($users);
        $naturalMethod = $methods->naturalMethodUpdateService($users);
        $mergeModernMethod = $modernMethodWithoutClinic->union($modernMethod)->get();
        $mergePermanentMethod = $permanentMethodWithoutClinic->union($permanentMethod)->get();
        $mergeNaturalMethod = $naturalMethodWithoutClinic->union($naturalMethod)->get();

        return response([
            'name' => 'Services',
            'permanentMethod' => $mergePermanentMethod,
            'naturalMethod' => $mergeNaturalMethod,
            'modernMethod' => $mergeModernMethod,
        ]);
    }

    public function getClinicGalleries($id)
    {
        $clinic = Staffs::where('user_id', $id)->pluck('clinic_id');

        $images = DB::table('clinic_gallery')
            ->select('id', 'file_name', 'file_url', 'value_id')
            ->where('clinic_id', $clinic[0])
            ->limit(5)
            ->get();
        return response([
            'name' => 'ClinicGalleries',
            'images' => $images,
        ]);
    }

    public function updateClinicGallery(Request $requests, $id)
    {
        $eee = 0;
        $user = Staffs::where('user_id', $id)->pluck('clinic_id');
        ClinicGallery::where('clinic_id', $user[0])->delete();
        for ($eee === 0;$eee <= 4;$eee++) {
            $fff = $eee + 1;
            $icon = $requests->file('image_'.$fff);
            $destination = public_path('/uploads');
            if ($icon !== null) {
                $icon->move($destination, $icon->getClientOriginalName());
                $icon_url = url('uploads/'.$icon->getClientOriginalName());
                ClinicGallery::create([
                    'file_name' => $icon->getClientOriginalName(),
                    'file_url' => $icon_url,
                    'clinic_id' => $user[0],
                ]);
            } else {
                ClinicGallery::create([
                    'file_name' => null,
                    'file_url' => null,
                    'clinic_id' => $user[0],
                ]);
            }
        }

        $images = DB::table('clinic_gallery')
            ->select('id', 'file_name', 'file_url')
            ->where('clinic_id', $user[0])
            ->get();
        return response([
            'name' => 'ClinicGalleries',
            'images' => $images,
        ]);
    }

    public function getPaidServices($id)
    {
        $user = Staffs::where('user_id', $id)->pluck('clinic_id');
        $fpm = new FamilyPlanTypeSubcategories();
        $checkedMethods = $fpm->checkedMethodsGetPaidServices($user);

        return response([
            'name' => 'PaidServices',
            'services' => $checkedMethods,
        ], 200);
    }

    public function updatePaidService($id, Request $requests)
    {
        $obj = json_decode($requests->getContent(), true);
        $user = Staffs::where('user_id', $id)->pluck('clinic_id');
        $fpm = new FamilyPlanTypeSubcategories();
        PaidServices::where('clinic_id', $user[0])->delete();
        for ($eee = 0; $eee <= 10000;$eee++) {
            if (isset($obj['available_method'][$eee])) {
                PaidServices::create([
                    'service_id' => $obj['available_method'][$eee],
                    'clinic_id' => $user[0],
                    'is_checked' => 1,
                ]);
            }
        }
        $data = $fpm->getUncheckedPaidServices($user);
        foreach ($data as $datas) {
            PaidServices::create([
                'service_id' => $datas->id,
                'clinic_id' => $user[0],
                'is_checked' => 0,
            ]);
        }
        $methods = $fpm->methodsUpdatePaidServices();
        $checkedMethods = $fpm->checkedMethodsUpdatePaidServices($user);
        $merged = $methods->union($checkedMethods)->get();

        return response([
            'name' => 'PaidServices',
            'services' => $merged,
        ], 200);
    }

    public function getFPMDetails()
    {
        $modernMethod = DB::table('family_plan_type_subcategory')
            ->select('id', 'icon_url', 'name', 'short_name', 'percent_effective', DB::raw("'Modern Method' as method_name"))
            ->where('family_plan_type_id', 1)
            ->get();

        $permanentMethod = DB::table('family_plan_type_subcategory')
            ->select('id', 'icon_url', 'name', 'short_name', 'percent_effective', DB::raw("'Permanent Method' as method_name"))
            ->where('family_plan_type_id', 2)
            ->get();

        $naturalMethod = DB::table('family_plan_type_subcategory')
            ->select('id', 'icon_url', 'name', 'short_name', 'percent_effective', DB::raw("'Natural Method' as method_name"))
            ->where('family_plan_type_id', 3)
            ->get();

        return response([
            'name' => 'FPMPage',
            'modernMethod' => $modernMethod,
            'permanentMethod' => $permanentMethod,
            'naturalMethod' => $naturalMethod,
        ]);
    }
    //APIs for Booking (from service page)
    public function fpmPagePerMethod($id)
    {
        $fpm = new FamilyPlanTypeSubcategories();
        $header = $fpm->fpmPerPageHeader($id);
        $description = $fpm->fpmPerPageDescription($id);
        $videolink = $fpm->fpmPerPageVideoLink($id);
        $gallery = $fpm->fpmPerPageGallery($id);

        $clinic = DB::table('paid_services')
            ->join('clinics', 'paid_services.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.photo_url', 'clinics.street_address', 'clinics.type', 'clinics.philhealth_accredited_1', 'paid_services.is_checked as paid_service')
            ->where('paid_services.service_id', $id)
            ->get();

        return response([
            'name' => 'fpmDetailsPerMethod',
            'headers' => $header,
            'videolink' => $videolink,
            'description' => $description,
            'gallery' => $gallery,
            'clinic' => $clinic,
        ]);
    }

    public function getAllFPM()
    {
        $fpm = DB::table('family_plan_type_subcategory')
            ->select('id', 'icon_url', 'name', 'description_filipino', 'description_english', 'short_name', 'percent_effective', 'family_plan_type_id')
            ->get();

        return response([$fpm]);
    }

    public function getProviderTimeSlot($id)
    {
        $clinic = Staffs::where('user_id', $id)->pluck('clinic_id');
        PatientTimeSlot::updateOrCreate(['clinic_id' => $clinic[0]]);

        $data = DB::table('patient_time_slot')
            ->select('number_of_slots')
            ->where('clinic_id', $clinic[0])
            ->get();

        return response([
            'name' => 'GetTimeSlot',
            'details' => $data,
        ]);
    }

    public function getHolidayManagementDetails($id)
    {
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $details = DB::table('holiday')->select('id', 'date', 'holiday_title')->where('clinic_id', $getClinicId[0])->where('is_saved', 1)->orderBy('date')->get();

        return response([
            'name' => 'getHoliday',
            'details' => $details,
        ]);
    }

    public function holidayManagementPost(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $searchDate = DB::table('holiday')->select('id')->where('date', $obj['date'][0])->where('clinic_id', $getClinicId[0])->count();

        if ($searchDate >= 1) {
            return response([
                'message' => 'Date you are entered are already posted. please choose another date',
            ]);
        }

        Holiday::create([
            'clinic_id' => $getClinicId[0],
            'date' => $obj['date'][0],
            'holiday_title' => $obj['holiday_title'][0],
        ]);

        $data = Holiday::all();

        return response([
            'name' => 'PostHoliday',
            'details' => $data,
        ]);
    }

    public function holidayManagementDeleteHoliday($id)
    {
        Holiday::where('id', $id)->delete();

        return response([
            'name' => 'DeleteHoliday',
            'message' => 'Holiday Deleted',
        ]);
    }

    public function holidaySaveChanges($id)
    {
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        Holiday::where('clinic_id', $getClinicId[0])->update([
            'is_saved' => 1,
        ]);
    }

    public function showCreatedHoliday($id)
    {
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $details = DB::table('holiday')->select('id', 'date', 'holiday_title')->where('clinic_id', $getClinicId[0])->where('is_saved', null)->get();

        return response([
            'name' => 'showCreatedHoliday',
            'details' => $details,
        ]);
    }
    public function deleteCreatedHoliday($id)
    {
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        DB::table('holiday')->where('is_saved', null)->where('clinic_id', $getClinicId[0])->delete();

        return response([
            'name' => 'deleteCreatedHoliday',
            'message' => 'created holiday deleted',
        ]);
    }
    public function postProviderTimeSlot(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        $clinic = Staffs::where('user_id', $id)->pluck('clinic_id');
        $clinicTime = new ClinicTime();
        ClinicTime::where('clinic_id', $clinic[0])->delete();
        $days = $clinicTime->CreateTimeDuration($clinic[0]);
        $clinicTime->CreateTime($days, $clinic[0]);
        $data = DB::table('patient_time_slot')
            ->select('number_of_slots')
            ->where('clinic_id', $clinic[0])
            ->pluck('number_of_slots');

        if ($data[0] === null) {
            PatientTimeSlot::create([
                'clinic_id' => $clinic[0],
                'number_of_slots' => $obj['timeslot'][0],
            ]);
        } else {
            PatientTimeSlot::where('clinic_id', $clinic[0])->update([
                'number_of_slots' => $obj['timeslot'][0],
            ]);
        }

        return response([
            'name' => 'postTimeSlot',
            'details' => $obj['timeslot'][0],
        ]);
    }

    public function getPaidService()
    {
        return PaidServices::get();
    }
}
