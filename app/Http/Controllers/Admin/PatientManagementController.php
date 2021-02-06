<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Exports\PatientListExport;
use App\FpmTypeService;
use App\Http\Controllers\Controller;
use App\MedicalHistory;
use App\Spouses;
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
        $fpmType = new FpmTypeService();
        $spouses = new Spouses();
        $medicalHistory = new MedicalHistory();
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
            $fpm = $fpmType->patientManagementInformation($id);
            $medical_history = $medicalHistory->patientManagementInformation($id);
            $personal_history = DB::table('patients')->select('civil_status', 'street_address', 'religion', 'occupation', 'city', 'province', 'monthly_income_1', 'city', 'province', 'barangay', 'no_of_living_children', 'do_you_have_plan_children')->where('user_id', $id)->get();
            $spouse = $spouses->patientmanagementInformation($id);
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
        $users = new User();
        $validator = \Validator::make(request()->all(), [
            'age-range' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('patient/list')
                ->withErrors($validator)
                ->withInput();
        }
        if ($request['age-range'] === '1') {
            $details = $users->patientsLessNineteen($request);
        } else {
            $details = $users->patientsMoreThanTwenty($request);
        }
        $age = $request['age-range'];
        $dateFrom = $request['date-from'];
        $dateTo = $request['date-to'];
        return view('admin.patientManagement.filter', ['details' => $details, 'age' => $age, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo]);
    }
}
