<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Http\Controllers\Controller;
use App\MedicalHistory;
use App\MedicalHistoryAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalHistoryController extends Controller
{
    public function postMedicalHistory(Request $request, $id, $questionid)
    {
        $obj = json_decode($request->getContent(), true);
        if ($questionid === '11') {
            $this->processQuestion11($obj, $id, $questionid);
        } elseif ($questionid === '12') {
            $this->processQuestion12($obj, $id, $questionid);
        } else {
            $this->processQuestion($obj, $id, $questionid);
        }
    }

    public function getPerPage($id, $questionid)
    {
        if ($questionid === '11') {
            $details = DB::table('medical_history_answer')
                ->select('question_id as question_no', DB::raw('null as yes'), DB::raw('null as no'), 'answer', 'string_answer_1 as string_answer')
                ->where('question_id', $questionid)
                ->where('patient_id', $id)
                ->get();

            $data = $details;
        } else {
            $data = DB::table('medical_history')
                ->select('question_no', 'yes', 'no')
                ->where('question_no', $questionid)
                ->where('patient_id', $id)
                ->get();
        }

        return response([
            'name' => 'getMedicalHistoryPerPage',
            'details' => $data,
        ]);
    }

    public function answer($id)
    {
        $details = DB::table('medical_history_answer')
            ->select('question_id as question_no', DB::raw('null as yes'), DB::raw('null as no'), 'answer', 'string_answer_1', 'string_answer')
            ->where('patient_id', $id);

        $detail = DB::table('medical_history')
            ->select('question_no', 'yes', 'no', DB::raw('null as answer'), DB::raw('null as string_answer'), DB::raw('null as string_answer_1'))
            ->where('patient_id', $id);
        $data = $details->union($detail)->get();

        return response([
            'name' => 'finalAnswerMedicalHistory',
            'details' => $data,
        ]);
    }

    private function processQuestion($obj, $id, $questionid)
    {
        MedicalHistory::where(['patient_id' => $id, 'question_no' => $questionid])->delete();
        if ($obj['answer'][0] === 0) {
            MedicalHistory::create([
                'patient_id' => $id,
                'question_no' => $questionid,
                'no' => 1,
                'yes' => null,
            ]);
        } else {
            MedicalHistory::create([
                'patient_id' => $id,
                'question_no' => $questionid,
                'no' => null,
                'yes' => 1,
            ]);
        }
    }

    private function processQuestion11($obj, $id, $questionid)
    {
        MedicalHistoryAnswer::where(['patient_id' => $id, 'question_id' => $questionid])->delete();
        $string_value = [];
        $count = count($obj['answer']) + 1;
        for ($eee = 0; $eee < $count; $eee++) {
            $data = $obj['string_values'];
            if (isset($obj['answer'][$eee])) {
                $string_value[] = $data[$obj['answer'][$eee]];
                $this->processWithOther($eee, $obj, $id, $questionid);
            }
        }
        MedicalHistoryAnswer::create([
            'patient_id' => $id,
            'question_id' => $questionid,
            'string_answer_1' => json_encode($string_value),
            'answer' => json_encode($obj['answer']),
        ]);
    }

    private function processQuestion12($obj, $id, $questionid)
    {
        MedicalHistoryAnswer::where(['patient_id' => $id, 'question_id' => $questionid])->delete();
        MedicalHistoryAnswer::create([
            'patient_id' => $id,
            'question_id' => $questionid,
            'string_answer_1' => $obj['input'][0],
        ]);
    }

    private function processWithOther($eee, $obj, $id, $questionid)
    {
        if (isset($obj['answer'])) {
            if ($obj['answer'][$eee] === 7) {
                MedicalHistoryAnswer::where([
                    'patient_id' => $id,
                    'question_id' => $questionid,
                ])->update([
                    'string_answer' => $obj['input'][0],
                ]);
            }
        }
    }
}
