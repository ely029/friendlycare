<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\FpmTypeService;
use App\Http\Controllers\Controller;
use App\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FPMController extends Controller
{
    public function pages($pageid, $id)
    {
        if ($pageid === '1') {
            $data = DB::table('patients')->select('fpm_user_type')->where('user_id', $id)->pluck('fpm_user_type');
            if ($data[0] === null) {
                return response([
                    'name' => 'fpmUserType',
                    'answer' => false,
                ]);
            }
            $services = DB::table('fpm_type_service')->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                ->select('family_plan_type_subcategory.id', 'family_plan_type_subcategory.name')
                ->where('fpm_type_service.patient_id', $id)
                ->get();
            $reasons = [
                ['id' => 1, 'name' => 'Limiting'],
                ['id' => 2, 'name' => 'Spacing'],
                ['id' => 3, 'name' => 'Others'],
            ];
            $fpms = [
                ['id' => 1, 'name1' => 'New Acceptor'],
                ['id' => 2, 'name1' => 'Changing Methods'],
                ['id' => 3, 'name1' => 'Current User'],
                ['id' => 4, 'name1' => 'Restart'],
            ];
            $fpm = DB::table('patients')->select('fpm_user_type')->where('user_id', $id)->pluck('fpm_user_type');
            $answer1 = $fpm[0] - 1;
            $reason = DB::table('patients')->select('family_plan_reasons')->where('user_id', $id)->pluck('family_plan_reasons');
            $answer = $reason[0] - 1;
            return response([
                'name' => 'fpmUserType',
                'answer' => true,
                'use_FPM' => 'Yes',
                'services' => $services,
                'reasons' => $reasons[$answer]['name'],
                'fpm_type' => $fpms[$answer1]['name1'],
            ]);
        }
        if ($pageid === '2') {
            $data = DB::table('patients')->select('family_plan_reasons')->where('user_id', $id)->pluck('family_plan_reasons');
            return response([
                'name' => 'fpmUserType',
                'answer' => $data[0],
            ]);
        }
        if ($pageid === '3') {
            $modernMethodWithAnswer = DB::table('fpm_type_service')
                ->join('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                ->select('family_plan_type_subcategory.id as fpm_id', 'family_plan_type_subcategory.name', 'fpm_type_service.service_id as id')
                ->where('fpm_type_service.patient_id', $id)
                ->where('family_plan_type_subcategory.is_approve', 1)
                ->where('fpm_type_service.id', '<>', null)
                ->where('family_plan_type_subcategory.family_plan_type_id', 1);
            $modernMethod = DB::table('family_plan_type_subcategory')
                ->leftJoin('fpm_type_service', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                ->select('family_plan_type_subcategory.id as fpm_id', 'family_plan_type_subcategory.name', 'fpm_type_service.service_id as id')
                ->where('family_plan_type_subcategory.family_plan_type_id', 1)
                ->where('family_plan_type_subcategory.is_approve', 1);
            $permanentMethodWithAnswer = DB::table('fpm_type_service')
                ->join('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                ->select('family_plan_type_subcategory.id as fpm_id', 'family_plan_type_subcategory.name', 'fpm_type_service.service_id as id')
                ->where('fpm_type_service.patient_id', $id)
                ->where('fpm_type_service.service_id', '<>', null)
                ->where('family_plan_type_subcategory.is_approve', 1)
                ->where('family_plan_type_subcategory.family_plan_type_id', 2);
            $permanentMethod = DB::table('family_plan_type_subcategory')
                ->leftJoin('fpm_type_service', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                ->select('family_plan_type_subcategory.id as fpm_id', 'family_plan_type_subcategory.name', 'fpm_type_service.service_id as id')
                ->where('family_plan_type_subcategory.family_plan_type_id', 2)
                ->where('family_plan_type_subcategory.is_approve', 1);
            $naturalMethodWithAnswer = DB::table('fpm_type_service')
                ->join('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                ->select('family_plan_type_subcategory.id as fpm_id', 'family_plan_type_subcategory.name', 'fpm_type_service.service_id as id')
                ->where('fpm_type_service.patient_id', $id)
                ->where('fpm_type_service.service_id', '<>', null)
                ->where('family_plan_type_subcategory.is_approve', 1)
                ->where('family_plan_type_subcategory.family_plan_type_id', 3);
            $naturalMethod = DB::table('family_plan_type_subcategory')
                ->leftJoin('fpm_type_service', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                ->select('family_plan_type_subcategory.id as fpm_id', 'family_plan_type_subcategory.name', 'fpm_type_service.service_id as id')
                ->where('family_plan_type_subcategory.family_plan_type_id', 3)
                ->where('family_plan_type_subcategory.is_approve', 1);
            $joinModern = $modernMethod->union($modernMethodWithAnswer)->get();
            $joinPermanent = $permanentMethod->union($permanentMethodWithAnswer)->get();
            $joinNatural = $naturalMethod->union($naturalMethodWithAnswer)->get();
            return response([
                'name' => 'fpmUserType',
                'modernMethod' => $joinModern,
                'permanentMethod' => $joinPermanent,
                'naturalMethod' => $joinNatural,
            ]);
        }
    }

    public function post(Request $request, $pageid, $id)
    {
        $obj = json_decode($request->getContent(), true);

        if ($pageid === '1') {
            Patients::where('user_id', $id)->update([
                'fpm_user_type' => $obj['fpm_user_type'][0],
            ]);

            return response([
                'name' => 'postFPMType',
                'answer' => $obj['fpm_user_type'][0],
            ]);
        }

        if ($pageid === '2') {
            Patients::where('user_id', $id)->update([
                'family_plan_reasons' => $obj['family_plan_reason'][0],
            ]);

            return response([
                'name' => 'postFPMType',
                'answer' => $obj['family_plan_reason'][0],
            ]);
        }

        if ($pageid === '3') {
            $number = count($obj['methods']) - 1;
            FpmTypeService::where('patient_id', $id)->delete();
            for ($eee = 0; $eee <= $number;$eee++) {
                FpmTypeService::create([
                    'service_id' => $obj['methods'][$eee],
                    'patient_id' => $id,
                ]);
            }

            return response([
                'name' => 'postFPMType',
                'answer' => 'saved successfully',
            ]);
        }
    }
}
