<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function header(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $number_of_patients = DB::table('booking')->select('id')->where('clinic_id', $getClinicId[0])
            ->whereBetween('booking.time_slot', [$obj['date_from'][0], $obj['date_to'][0]])
            ->count();
        return response([
            'name' => 'header',
            'number_of_patients' => $number_of_patients,
            'date_from' => date_format(date_create($obj['date_from'][0]), 'M d'),
            'date_to' => date_format(date_create($obj['date_to'][0]), 'M d'),
        ]);
    }

    public function availableServices(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $data = DB::table('booking')
            ->select('family_plan_type_subcategory.name as service',
                    DB::raw(' count(booking.id) as services_count'))
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->where('booking.clinic_id', $getClinicId[0])
            ->whereBetween('booking.time_slot', [$obj['date_from'][0], $obj['date_to'][0]])
            ->groupBy(['family_plan_type_subcategory.name'])
            ->get();

        return response([
            'name' => 'availableService',
            'details' => $data,
        ]);
    }

    public function status(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $confirmed = DB::table('booking')->select('id')->where('clinic_id', $getClinicId[0])->where('status', 1)->whereBetween('booking.time_slot', [$obj['date_from'][0], $obj['date_to'][0]])->count();
        $reschedule = DB::table('booking')->select('id')->where('clinic_id', $getClinicId[0])->where('status', 2)->whereBetween('booking.time_slot', [$obj['date_from'][0], $obj['date_to'][0]])->count();
        $cancelled = DB::table('booking')->select('id')->where('clinic_id', $getClinicId[0])->where('status', 3)->whereBetween('booking.time_slot', [$obj['date_from'][0], $obj['date_to'][0]])->count();
        $complete = DB::table('booking')->select('id')->where('clinic_id', $getClinicId[0])->where('status', 4)->whereBetween('booking.time_slot', [$obj['date_from'][0], $obj['date_to'][0]])->count();
        $noShow = DB::table('booking')->select('id')->where('clinic_id', $getClinicId[0])->where('status', 5)->whereBetween('booking.time_slot', [$obj['date_from'][0], $obj['date_to'][0]])->count();
        $pending = DB::table('booking')->select('id')->where('clinic_id', $getClinicId[0])->where('status', 6)->whereBetween('booking.time_slot', [$obj['date_from'][0], $obj['date_to'][0]])->count();

        return response([
            'name' => 'status',
            'confirmed' => $confirmed,
            'reschedule' => $reschedule,
            'cancelled' => $cancelled,
            'complete' => $complete,
            'noShow' => $noShow,
        ]);
    }

    public function details(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $data = DB::table('booking')
            ->leftJoin('family_plan_type_subcategory', 'booking.service_id', 'family_plan_type_subcategory.id')
            ->leftJoin('booking_time', 'booking.id', 'booking_time.booking_id')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->select('users.name', DB::raw('DATE_FORMAT(booking.time_slot, "%M %d") as date_booked'), 'booking_time.time_slot', 'family_plan_type_subcategory.name as service_name', 'booking.referal', 'booking.status')
            ->whereBetween('booking.time_slot', [$obj['date_from'][0], $obj['date_to'][0]])
            ->where('booking.clinic_id', $getClinicId[0])
            ->get();

        return response([
            'name' => 'reportDetails',
            'details' => $data,
        ]);
    }
}
