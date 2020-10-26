<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Provider;

use App\ClinicGallery;
use App\ClinicHours;
use App\Clinics;
use App\ClinicService;
use App\Http\Controllers\Controller;
use App\PaidServices;
use App\Staffs;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class DefaultController extends Controller
{
    public function login()
    {
        $validator = \Validator::make(request()->all(), [
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (\Auth::attempt(['email' => request('email'), 'password' => request('password'), 'role_id' => 4])) {
            $user = \Auth::user();

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
        $users = User::where('email', $request['email'])->get();

        Mail::send('email.patient.account-reset', ['users' => $users], function ($mail) use ($request) {
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
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.professions', 'users.trainings')
            ->where('staffs.user_id', $id)
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
        $details = DB::table('clinics')
            ->select('clinics.email',
               'clinics.contact_number',
               'clinics.street_address',
               'clinics.description',
               'clinics.clinic_name',
               'clinics.city',
               'clinics.photo_url',
               'clinics.type',
               )
            ->where('clinics.id', $user['clinic_id'])
            ->get();

        return response([
            'data' => $details,
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
            ->join('staffs', 'staffs.clinic_id', 'clinics.id')
            ->join('clinic_hours', 'clinic_hours.clinic_id', 'clinics.id')
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
        ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['monday_label']])->update([
            'froms' => $request['monday_froms'],
            'tos' => $request['monday_tos'],
        ]);

        ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['tuesday_label']])->update([
            'froms' => $request['tuesday_froms'],
            'tos' => $request['tuesday_tos'],
        ]);

        ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['wednesday_label']])->update([
            'froms' => $request['wednesday_froms'],
            'tos' => $request['wednesday_tos'],
        ]);

        ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['thursday_label']])->update([
            'froms' => $request['thursday_froms'],
            'tos' => $request['thursday_tos'],
        ]);

        ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['friday_label']])->update([
            'froms' => $request['friday_froms'],
            'tos' => $request['friday_tos'],
        ]);

        ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['saturday_label']])->update([
            'froms' => $request['saturday_froms'],
            'tos' => $request['saturday_tos'],
        ]);

        ClinicHours::where(['clinic_id' => $clinic[0], 'days' => $request['sunday_label']])->update([
            'froms' => $request['sunday_froms'],
            'tos' => $request['sunday_tos'],
        ]);

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
        $modernMethod = DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id')
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('family_plan_type_subcategory.is_approve', 1)
            ->get();

        $permanentMethod = DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id')
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('family_plan_type_subcategory.is_approve', 1)
            ->get();

        $naturalMethod = DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id')
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('family_plan_type_subcategory.is_approve', 1)
            ->get();

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
        $modernMethodWithoutClinic = DB::table('family_plan_type_subcategory')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('clinic_service.is_checked', null);

        $permanentMethodWithoutClinic = DB::table('family_plan_type_subcategory')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('clinic_service.is_checked', null);

        $naturalMethodWithoutClinic = DB::table('family_plan_type_subcategory')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('clinic_service.is_checked', null);

        $modernMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $users[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('clinic_service.is_checked', 1);

        $permanentMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $users[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('clinic_service.is_checked', 1);

        $naturalMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $users[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('clinic_service.is_checked', 1);

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

    public function updateServices($id, Request $requests)
    {
        $obj = json_decode($requests->getContent(), true);
        $users = Staffs::where('user_id', $id)->pluck('clinic_id');
        for ($eee = 0;$eee <= 10000;$eee++) {
            if (isset($obj['services'][$eee])) {
                ClinicService::create([
                    'clinic_id' => $users[0],
                    'service_id' => $obj['services'][$eee],
                    'is_checked' => 1,
                ]);
            }
        }

        $modernMethodWithoutClinic = DB::table('family_plan_type_subcategory')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('clinic_service.is_checked', null);

        $permanentMethodWithoutClinic = DB::table('family_plan_type_subcategory')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('clinic_service.is_checked', null);

        $naturalMethodWithoutClinic = DB::table('family_plan_type_subcategory')
            ->leftJoin('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('clinic_service.is_checked', null);

        $modernMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $users[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('clinic_service.is_checked', 1);

        $permanentMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $users[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('clinic_service.is_checked', 1);

        $naturalMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'clinic_service.is_checked')
            ->where('clinic_service.clinic_id', $users[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('clinic_service.is_checked', 1);

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
        $user = Staffs::where('user_id', $id)->pluck('clinic_id');
        $icon1 = $requests->file('image_1');
        if ($icon1 !== null) {
            $destination = public_path('/uploads');
            $icon1->move($destination, $icon1->getClientOriginalName());
            $icon_url = url('uploads/'.$icon1->getClientOriginalName());
            ClinicGallery::where(['clinic_id' => $user[0], 'value_id' => 0])->update([
                'file_name' => $icon1->getClientOriginalName(),
                'file_url' => $icon_url,
            ]);
        }

        $icon2 = $requests->file('image_2');
        if ($icon2 !== null) {
            $destination = public_path('/uploads');
            $icon2->move($destination, $icon2->getClientOriginalName());
            $icon_url = url('uploads/'.$icon2->getClientOriginalName());
            ClinicGallery::where(['clinic_id' => $user[0], 'value_id' => 1])->update([
                'file_name' => $icon2->getClientOriginalName(),
                'file_url' => $icon_url,
            ]);
        }

        $icon3 = $requests->file('image_3');
        if ($icon3 !== null) {
            $destination = public_path('/uploads');
            $icon3->move($destination, $icon3->getClientOriginalName());
            $icon_url = url('uploads/'.$icon3->getClientOriginalName());
            ClinicGallery::where(['clinic_id' => $user[0], 'value_id' => 2])->update([
                'file_name' => $icon3->getClientOriginalName(),
                'file_url' => $icon_url,
            ]);
        }

        $icon4 = $requests->file('image_4');
        if ($icon4 !== null) {
            $destination = public_path('/uploads');
            $icon4->move($destination, $icon4->getClientOriginalName());
            $icon_url = url('uploads/'.$icon4->getClientOriginalName());
            ClinicGallery::where(['clinic_id' => $user[0], 'value_id' => 3])->update([
                'file_name' => $icon4->getClientOriginalName(),
                'file_url' => $icon_url,
            ]);
        }

        $icon5 = $requests->file('image_5');
        if ($icon5 !== null) {
            $destination = public_path('/uploads');
            $icon5->move($destination, $icon5->getClientOriginalName());
            $icon_url = url('uploads/'.$icon5->getClientOriginalName());
            ClinicGallery::where(['clinic_id' => $user[0], 'value_id' => 4])->update([
                'file_name' => $icon5->getClientOriginalName(),
                'file_url' => $icon_url,
            ]);
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
        $methods = DB::table('family_plan_type_subcategory')
            ->leftJoin('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'paid_services.is_checked')
            ->where('paid_services.is_checked', null);

        $checkedMethods = DB::table('family_plan_type_subcategory')
            ->join('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'paid_services.is_checked')
            ->where('paid_services.is_checked', 1)
            ->where('paid_services.clinic_id', $user[0]);

        $merged = $methods->union($checkedMethods)->get();

        return response([
            'name' => 'PaidServices',
            'services' => $merged,
        ], 200);
    }

    public function updatePaidService($id, Request $requests)
    {
        $obj = json_decode($requests->getContent(), true);
        $user = Staffs::where('user_id', $id)->pluck('clinic_id');

        for ($eee = 0; $eee <= 10000;$eee++) {
            if (isset($obj['available_method'][$eee])) {
                PaidServices::create([
                    'service_id' => $obj['available_method'][$eee],
                    'clinic_id' => $user[0],
                    'is_checked' => 1,
                ]);
            }
        }

        $methods = DB::table('family_plan_type_subcategory')
            ->leftJoin('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'paid_services.is_checked')
            ->where('paid_services.is_checked', null);

        $checkedMethods = DB::table('family_plan_type_subcategory')
            ->join('paid_services', 'paid_services.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name', 'paid_services.is_checked')
            ->where('paid_services.is_checked', 1)
            ->where('paid_services.clinic_id', $user[0]);

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
            ->select('id', 'icon_url', 'name', 'short_name', 'percent_effective', DB::raw("'Natural Method' as method_name"))
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
        $header = DB::table('family_plan_type_subcategory')
            ->select('name', 'short_name', 'icon_url', 'percent_effective', 'typical_validity', 'family_plan_type_id')
            ->where('id', $id)
            ->get();

        $description = DB::table('family_plan_type_subcategory')
            ->select('description_filipino', 'how_it_works_filipino', 'side_effect_filipino', 'additional_note_filipino')
            ->where('id', $id)
            ->get();

        $videolink = DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.video_link')
            ->where('family_plan_type_subcategory.id', $id)
            ->get();

        $gallery = DB::table('family_plan_type_subcategory')
            ->join('service_gallery', 'service_gallery.service_id', 'family_plan_type_subcategory.id')
            ->select('family_plan_type_subcategory.video_link', 'service_gallery.file_url')
            ->where('family_plan_type_subcategory.id', $id)
            ->get();

        $clinic = DB::table('clinics')
            ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
            ->join('family_plan_type_subcategory', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->select('clinics.clinic_name', 'clinics.photo_url')
            ->where('clinic_service.service_id', $id)
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
}
