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
            $tagalog_questions = [
                ['id' => 1, 'question' => 'Ikaw ba ay nanganak ka ba sa nakaraang 6 weeks?'],
                ['id' => 2, 'question' => 'Ikaw ba ay kasalakuyang nagpapasuso?'],
                ['id' => 3, 'question' => 'Ikaw ba ay naninigarilyo?'],
                ['id' => 4, 'question' => 'Ikaw ba ay may altapresyon (high blood pressure)?'],
                ['id' => 5, 'question' => 'Ikaw ba ay may diabetes?'],
                ['id' => 6, 'question' => 'Ikaw ba ay nakakaranas ng matinding pagsakit ng ulo o migraine?'],
                ['id' => 7, 'question' => 'Ikaw ba ay may personal o sa iyong pamilya na karamdaman na may kinalaman sa dugo:'],
                ['id' => 8, 'question' => 'Ikaw ba ay may iba pang karamdaman?'],
                ['id' => 9, 'question' => 'Nagkaroon ka ba ng anumang mga pangunahing operasyon o mayroon kang anumang paparating operasyon?'],
                ['id' => 10, 'question' => 'Ikaw ba ay umiinom ng mga gamot para sa:'],
                ['id' => 11, 'question' => 'Ikaw ba ay allergic sa kahit na anong gamot'],
            ];
            $english_questions = [
                ['id' => 1, 'question' => 'Have you given birth in the last 6 weeks?'],
                ['id' => 2, 'question' => 'Are you currently breasfeeding?'],
                ['id' => 3, 'question' => 'Do you currently smoke or use a nicotine e-cigarette device?'],
                ['id' => 4, 'question' => 'Do you have highblood pressure?'],
                ['id' => 5, 'question' => 'Do you have diabetes?'],
                ['id' => 6, 'question' => 'Do you have severe headache or migraine with aura?'],
                ['id' => 7, 'question' => 'Do you have a personal or family history of deep vein thrombosis(DVP), pulmonary edema(PE), or blood clotting disorder?'],
                ['id' => 8, 'question' => 'Do you have any other medical conditions?'],
                ['id' => 9, 'question' => 'Have you had any major surgeries?'],
                ['id' => 10, 'question' => 'Have you currently take medications for:'],
                ['id' => 11, 'question' => 'Are you allergic to any medications?'],
            ];
            $details = DB::table('users')->select('users.id', 'users.name', 'users.age', 'users.birth_date', 'users.gender', 'users.email')->where('id', $id)->get();
            $fpm = DB::table('fpm_type_service')->join('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                ->select('family_plan_type_subcategory.name')
                ->where('fpm_type_service.patient_id', $id)
                ->get();
            $medical_history = DB::table('medical_history')->select('question_no', 'yes', 'no')->where('patient_id', $id)->get();
            $personal_history = DB::table('patients')->select('civil_status', 'street_address', 'religion', 'occupation', 'city', 'province', 'monthly_income_1', 'city', 'province', 'barangay', 'no_of_living_children', 'do_you_have_plan_children')->where('user_id', $id)->get();
            $spouse = DB::table('spouses')->select('spouse_first_name', 'spouse_last_name', 'spouse_birth_date', 'spouse_occupation')->where('patient_id', $id)->get();
            return view('admin.patientManagement.information', ['details' => $details, 'english_question' => $english_questions, 'fpm' => $fpm, 'tagalog_question' => $tagalog_questions, 'medical_history' => $medical_history, 'personal_history' => $personal_history, 'spouse' => $spouse]);
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
        $request = request()->all();
        $fileName = 'Patients-List.csv';
        return Excel::download(new PatientListExport($request['start_date'], $request['end_date'], $request['age']), $fileName);
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
                ->select('users.id', 'users.name', 'users.email', 'users.age', 'patients.province', DB::raw('DATE_FORMAT(users.created_at, "%m/%d/%Y") as registered_at'))
                ->whereBetween('users.created_at', [$request['date-from'], $request['date-to']])
                ->where('users.age', '<=', 19)
                ->get();
        } else {
            $details = DB::table('users')->leftJoin('patients', 'users.id', 'patients.user_id')
                ->select('users.id', 'users.name', 'users.email', 'users.age', 'patients.province', DB::raw('DATE_FORMAT(users.created_at, "%m/%d/%Y") as registered_at'))
                ->whereBetween('users.created_at', [$request['date-from'], $request['date-to']])
                ->where('users.age', '>=', 20)
                ->get();
        }
        $age = $request['age-range'];
        $dateFrom = $request['date-from'];
        $dateTo = $request['date-to'];
        return view('admin.patientManagement.filter', ['details' => $details, 'age' => $age, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo]);
    }
}
