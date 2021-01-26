<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Exports\PatientListExport;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PatientManagementController extends Controller
{
    public function index()
    {
        $details = DB::table('users')->leftjoin('patients', 'patients.user_id', 'users.id')->select('users.id', 'users.name', 'patients.province', 'users.email', 'users.age', DB::raw('DATE_FORMAT(users.created_at, "%m/%d/%Y") as registered_at'))->where('role_id', 3)->get();
        return view('admin.patientManagement.index', ['details' => $details]);
    }

    public function information($id)
    {
        if (Auth::user() !== null) {
            $questions = [
                ['id' => 1, 'question' => 'Nanganak ka ba sa nakaraang 6 weeks?'],
                ['id' => 2, 'question' => 'Kasalukuyang ka bang may pinapasuso (breastfreeding)?'],
                ['id' => 3, 'question' => 'Gumagamit ka ba ng sigarilyo?'],
                ['id' => 4, 'question' => 'Mayroon ka bang altapresyo (high blood pressure)?'],
                ['id' => 5, 'question' => 'Ikaw ba ay may diabetes?'],
                ['id' => 6, 'question' => 'May miyembro ba ng iyong pamilya na nagkaron ng sumusunod na kapansanan:'],
                ['id' => 7, 'question' => 'Sumailalim o sasailalim ka ba sa isang major surgery?'],
            ];
            $details = DB::table('users')->select('users.id', 'users.name', 'users.age', 'users.birth_date', 'users.gender', 'users.email')->where('id', $id)->get();
            $fpm = DB::table('fpm_type_service')->join('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                ->select('family_plan_type_subcategory.name')
                ->where('fpm_type_service.patient_id', $id)
                ->get();
            $medical_history = DB::table('medical_history')->select('question_no', 'yes', 'no')->where('patient_id', $id)->get();
            $personal_history = DB::table('patients')->select('civil_status', 'street_address', 'religion', 'occupation', 'city', 'province', 'monthly_income_1', 'city', 'province', 'barangay', 'no_of_living_children', 'do_you_have_plan_children')->where('user_id', $id)->get();
            $spouse = DB::table('spouses')->select('spouse_first_name', 'spouse_last_name', 'spouse_birth_date', 'spouse_occupation')->where('patient_id', $id)->get();
            return view('admin.patientManagement.information', ['details' => $details, 'fpm' => $fpm, 'question' => $questions, 'medical_history' => $medical_history, 'personal_history' => $personal_history, 'spouse' => $spouse]);
        }
        redirect('/logout');
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();

        return redirect('patient/list');
    }

    public function export()
    {
        $fileName = 'Patients-List.csv';
        return Excel::download(new PatientListExport(), $fileName);
    }

    public function filter()
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'age-range' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('patient/list')
                ->withErrors($validator)
                ->withInput();
        }
        if ($request['age-range'] === '1') {
            $details = DB::table('users')->leftJoin('patients', 'users.id', 'patients.user_id')
                ->select('users.id', 'users.name', 'users.email', 'users.age', 'patients.province')
                ->whereBetween('users.created_at', [$request['date-from'], $request['date-to']])
                ->where('users.age', '<=', 19)
                ->get();
        } else {
            $details = DB::table('users')->leftJoin('patients', 'users.id', 'patients.user_id')
                ->select('users.id', 'users.name', 'users.email', 'users.age', 'patients.province')
                ->whereBetween('users.created_at', [$request['date-from'], $request['date-to']])
                ->where('users.age', '>=', 20)
                ->get();
        }
        return view('admin.patientManagement.filter', ['details' => $details]);
    }
}
