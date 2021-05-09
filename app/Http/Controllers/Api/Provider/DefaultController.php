<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Provider;

use App\ChatBot;
use App\ChatBotResponse;
use App\ClinicGallery;
use App\ClinicHours;
use App\Clinics;
use App\ClinicService;
use App\ClinicTime;
use App\FamilyPlanTypeSubcategories;
use App\FcmRegistrationToken;
use App\Holiday;
use App\Http\Clients\FcmClient;
use App\Http\Controllers\Api\Users\FcmRegistrationTokensController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\FcmRegistrationTokens\DestroyRequest;
use App\Http\Requests\Api\Users\FcmRegistrationTokens\StoreRequest;
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
        $fcm = new FcmRegistrationTokensController();
        $fcm1 = new FcmClient();

        if (\Auth::attempt(['email' => $obj['email'], 'password' => $obj['password'], 'role_id' => 4])) {
            $user1 = \Auth::user();
            $user = User::where('id', $user1['id'])->first();
            $fcm->store($obj, $fcm1, $user);
            return response([
                'login_success' => 'Login Successful',
                'id' => $user1['id'],
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

    public function updateClinicHours($id, Request $request)
    {
        $request = json_decode($request->getContent(), true);
        $clinic = Staffs::where('user_id', $id)->pluck('clinic_id');
        ClinicHours::where('clinic_id', $clinic[0])->delete();
        $check_monday = ClinicHours::where('clinic_id', $clinic[0])->where('days', 'Monday')->count();
        $check_tuesday = ClinicHours::where('clinic_id', $clinic[0])->Where('days', 'Tuesday')->count();
        $check_wednesday = ClinicHours::where('clinic_id', $clinic[0])->where('days', 'Wednesday')->count();
        $check_thursday = ClinicHours::where('clinic_id', $clinic[0])->where('days', 'Thursday')->count();
        $check_friday = ClinicHours::where('clinic_id', $clinic[0])->where('days', 'Friday')->count();
        $check_saturday = ClinicHours::where('clinic_id', $clinic[0])->where('days', 'Saturday')->count();
        $check_sunday = ClinicHours::where('clinic_id', $clinic[0])->where('days', 'Sunday')->count();
        if ($check_monday >= 1) {
            ClinicHours::where('clinic_id', $clinic[0])->where('days', 'Monday')->orWhere('days', 'monday')->update(['froms' => $request['monday_froms'][0], 'tos' => $request['monday_tos'][0]]);
        } else {
            ClinicHours::create(['days' => 'Monday', 'is_checked' => 1, 'froms' => $request['monday_froms'][0], 'tos' => $request['monday_tos'][0], 'clinic_id' => $clinic[0]]);
        }

        if ($check_tuesday >= 1) {
            ClinicHours::where('clinic_id', $clinic[0])->where('days', 'Tuesday')->update(['froms' => $request['tuesday_froms'][0],'tos' => $request['tuesday_tos'][0]]);
        } else {
            ClinicHours::create(['days' => 'Tuesday', 'is_checked' => 1, 'froms' => $request['tuesday_froms'][0], 'tos' => $request['tuesday_tos'][0], 'clinic_id' => $clinic[0]]);
        }
        if ($check_wednesday >= 1) {
            ClinicHours::where('clinic_id', $clinic[0])->where('days', 'Wednesday')->orWhere('days', 'wednesday')->update(['froms' => $request['wednesday_froms'][0], 'tos' => $request['wednesday_tos'][0]]);
        } else {
            ClinicHours::create(['days' => 'Wednesday', 'is_checked' => 1, 'froms' => $request['wednesday_froms'][0], 'tos' => $request['wednesday_tos'][0], 'clinic_id' => $clinic[0]]);
        }
        if ($check_thursday >= 1) {
            ClinicHours::where('clinic_id', $clinic[0])->where('days', 'Thursday')->orWhere('days', 'thursday')->update(['froms' => $request['thursday_froms'][0], 'tos' => $request['thursday_tos'][0]]);
        } else {
            ClinicHours::create([ 'days' => 'Thursday', 'is_checked' => 1, 'froms' => $request['thursday_froms'][0], 'tos' => $request['thursday_tos'][0],  'clinic_id' => $clinic[0]]);
        }
        if ($check_friday >= 1) {
            ClinicHours::where('clinic_id', $clinic[0])->where('days', 'Friday')->orWhere('days', 'friday')->update(['froms' => $request['friday_froms'][0], 'tos' => $request['friday_tos'][0]]);
        } else {
            ClinicHours::create(['days' => 'Friday', 'is_checked' => 1, 'froms' => $request['friday_froms'][0], 'tos' => $request['friday_tos'][0], 'clinic_id' => $clinic[0]]);
        }

        if ($check_saturday >= 1) {
            ClinicHours::where('clinic_id', $clinic[0])->where('days', 'Saturday')->orWhere('days', 'saturday')->update(['froms' => $request['saturday_froms'][0], 'tos' => $request['saturday_tos'][0], 'clinic_id' => $clinic[0]]);
        } else {
            ClinicHours::create(['days' => 'Saturday', 'is_checked' => 1, 'froms' => $request['saturday_froms'][0], 'tos' => $request['saturday_tos'][0], 'clinic_id' => $clinic[0]]);
        }

        if ($check_sunday >= 1) {
            ClinicHours::where('clinic_id', $clinic[0])->where('days', 'Sunday')->orWhere('days', 'sunday')->update(['froms' => $request['sunday_froms'][0], 'tos' => $request['sunday_tos'][0], 'clinic_id' => $clinic[0]]);
        } else {
            ClinicHours::create(['days' => 'Sunday', 'is_checked' => 1, 'froms' => $request['sunday_froms'][0], 'tos' => $request['sunday_tos'][0], 'clinic_id' => $clinic[0]]);
        }

        return response([
            'data' => 0,
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
            $file = $requests->file('image_'.$fff);
            if (isset($file)) {
                $icon = $requests->file('image_'.$fff);
                $icon->storeAs('public', $icon->getClientOriginalName());
                $icon_url = url('storage/'.$icon->getClientOriginalName());
                ClinicGallery::create([
                    'file_name' => $icon->getClientOriginalName(),
                    'file_url' => $icon_url,
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

        $clinic = DB::table('clinic_service')
            ->join('clinics', 'clinic_service.clinic_id', 'clinics.id')
            ->select('clinics.id', 'clinics.clinic_name', 'clinics.photo_url', 'clinics.street_address', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinic_service.is_checked as paid_service')
            ->where('clinic_service.service_id', $id)
            ->where('clinic_service.is_checked', 1)
            ->where('clinics.is_close', '<>', 1)
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
        $holiday = new Holiday();
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $searchDate = DB::table('holiday')->select('id')->where('date', $obj['date'][0])->where('clinic_id', $getClinicId[0])->count();

        if ($searchDate >= 1) {
            return response([
                'message' => 'Date you are entered are already posted. please choose another date',
            ]);
        }

        $holiday->createHoliday($getClinicId, $obj);

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
        $patientTimeSlot = new PatientTimeSlot();
        ClinicTime::where('clinic_id', $clinic[0])->delete();
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        for ($hhh = 0; $hhh < 7; $hhh++) {
            $clinicTime->CreateTimeDuration($clinic[0], $days[$hhh]);
        }
        $data = DB::table('patient_time_slot')
            ->select('number_of_slots')
            ->where('clinic_id', $clinic[0])
            ->count();

        if ($data <= 0) {
            $patientTimeSlot->createTimeSlot($clinic, $obj);
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

    public function logout($id)
    {
        $fcm = new FcmRegistrationTokensController();
        $fcm1 = new FcmClient();
        $user = new User();
        $registrationId = FcmRegistrationToken::where('user_id', $id)->first();
        $fcm->destroy($registrationId, $fcm1, $user);
        return true;
    }

    public function chatBot()
    {
        return ChatBot::all();
    }

    public function chatBotResponse()
    {
        return ChatBotResponse::all();
    }
}
