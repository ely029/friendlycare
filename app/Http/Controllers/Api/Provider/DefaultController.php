<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Provider;

use App\ClinicGallery;
use App\ClinicHours;
use App\Clinics;
use App\Http\Controllers\Controller;
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

    public function getServices($id)
    {
        $users = Staffs::where('user_id', $id)->pluck('clinic_id');
        $modernMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'clinic_service.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->where('clinic_service.clinic_id', $users[0])
            ->where('family_plan_type_subcategory.is_approve', 1)
            ->get();

        $permanentMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'clinic_service.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->where('clinic_service.clinic_id', $users[0])
            ->where('family_plan_type_subcategory.is_approve', 1)
            ->get();

        $naturalMethod = DB::table('family_plan_type_subcategory')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->select('family_plan_type_subcategory.name', 'family_plan_type_subcategory.id', 'clinic_service.is_checked')
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->where('clinic_service.clinic_id', $users[0])
            ->where('family_plan_type_subcategory.is_approve', 1)
            ->get();

        return response([
            'name' => 'Services',
            'permanentMethod' => $permanentMethod,
            'naturalMethod' => $naturalMethod,
            'modernMethod' => $modernMethod,
        ]);
    }

    public function getClinicGalleries($id)
    {
        $clinic = Staffs::where('user_id', $id)->pluck('clinic_id');

        $images = DB::table('clinic_gallery')
            ->select('id', 'file_name', 'file_url')
            ->where('clinic_id', $clinic[0])
            ->limit(5)
            ->get();
        return response([
            'name' => 'ClinicGalleries',
            'images' => $images,
        ]);
    }

    public function updateClinicGallery($id, Request $requests)
    {
        $user = Staffs::where('user_id', $id)->pluck('clinic_id');

        if ($requests->file('image_1') !== null) {
            $icon = $requests->file('image_1');
            $destination = public_path('/uploads');
            $icon->move($destination, $icon->getClientOriginalName());
            $icon_url = url('uploads/'.$icon->getClientOriginalName());
            ClinicGallery::where(['clinic_id' => $user[0], 'value_id' => 0])->update([
                'file_name' => $icon->getClientOriginalName(),
                'file_url' => $icon_url,
            ]);
        }

        if ($requests->file('image_2') !== null) {
            $icon = $requests->file('image_2');
            $destination = public_path('/uploads');
            $icon->move($destination, $icon->getClientOriginalName());
            $icon_url = url('uploads/'.$icon->getClientOriginalName());
            ClinicGallery::where(['clinic_id' => $user[0], 'value_id' => 1])->update([
                'file_name' => $icon->getClientOriginalName(),
                'file_url' => $icon_url,
            ]);
        }

        if ($requests->file('image_3') !== null) {
            $icon = $requests->file('image_3');
            $destination = public_path('/uploads');
            $icon->move($destination, $icon->getClientOriginalName());
            $icon_url = url('uploads/'.$icon->getClientOriginalName());
            ClinicGallery::where(['clinic_id' => $user[0], 'value_id' => 2])->update([
                'file_name' => $icon->getClientOriginalName(),
                'file_url' => $icon_url,
            ]);
        }

        if ($requests->file('image_4') !== null) {
            $icon = $requests->file('image_4');
            $destination = public_path('/uploads');
            $icon->move($destination, $icon->getClientOriginalName());
            $icon_url = url('uploads/'.$icon->getClientOriginalName());
            ClinicGallery::where(['clinic_id' => $user[0], 'value_id' => 3])->update([
                'file_name' => $icon->getClientOriginalName(),
                'file_url' => $icon_url,
            ]);
        }

        if ($requests->file('image_5') !== null) {
            $icon = $requests->file('image_5');
            $destination = public_path('/uploads');
            $icon->move($destination, $icon->getClientOriginalName());
            $icon_url = url('uploads/'.$icon->getClientOriginalName());
            ClinicGallery::where(['clinic_id' => $user[0], 'value_id' => 4])->update([
                'file_name' => $icon->getClientOriginalName(),
                'file_url' => $icon_url,
            ]);
        }

        $images = DB::table('clinic_gallery')
            ->select('id', 'file_name', 'file_url')
            ->where('clinic_id', $user[0])
            ->limit(5)
            ->get();
        return response([
            'name' => 'ClinicGalleries',
            'images' => $images,
        ]);
    }
}
