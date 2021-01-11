<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Clinics;
use App\FamilyPlanTypeSubcategories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $services = FamilyPlanTypeSubcategories::where('is_approve', 1)->get();
        $clinics = Clinics::where('is_approve', 1)->get();
        return view('admin.bookings.index', ['services' => $services, 'clinics' => $clinics]);
    }

    public function results()
    {
        $request = request()->all();
        $count_patients = DB::table('booking')
            ->select(['id'])
            ->where('clinic_id', $request['clinic_id'])
            ->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])
            ->where('booking.clinic_id', $request['clinic_id'])
            ->where('booking.service_id', $request['service_id'])
            ->where('booking.status', '<>', 6)
            ->count();
        $availed_service = DB::table('booking')
            ->select('family_plan_type_subcategory.name as service',
                    DB::raw(' count(booking.id) as services_count'))
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->where('booking.clinic_id', $request['clinic_id'])
            ->where('booking.service_id', $request['service_id'])
            ->where('booking.status', '<>', 6)
            ->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])
            ->groupBy(['family_plan_type_subcategory.name'])
            ->get();
        $confirmed = DB::table('booking')->select('id')->where('clinic_id', $request['clinic_id'])->Where('service_id', $request['service_id'])->where('status', 1)->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])->count();
        $reschedule = DB::table('booking')->select('id')->where('clinic_id', $request['clinic_id'])->Where('service_id', $request['service_id'])->where('status', 2)->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])->count();
        $cancelled = DB::table('booking')->select('id')->where('clinic_id', $request['clinic_id'])->Where('service_id', $request['service_id'])->where('status', 3)->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])->count();
        $complete = DB::table('booking')->select('id')->where('clinic_id', $request['clinic_id'])->Where('service_id', $request['service_id'])->where('status', 4)->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])->count();
        $noShow = DB::table('booking')->select('id')->where('clinic_id', $request['clinic_id'])->Where('service_id', $request['service_id'])->where('status', 5)->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])->count();
        $provider = DB::table('clinics')->select('id', 'clinic_name')->where('is_approve', 1)->get();
        $service = DB::table('family_plan_type_subcategory')->select('id', 'name')->where('is_approve', 1)->get();

        $details = DB::table('booking')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('clinics', 'clinics.id', 'booking.clinic_id')
            ->select('users.name', 'family_plan_type_subcategory.name as service_name', 'clinics.clinic_name', 'booking.status', 'booking.time_slot as booked_date')
            ->where('booking.clinic_id', $request['clinic_id'])
            ->where('booking.service_id', $request['service_id'])
            ->where('booking.status', '<>', 6)
            ->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])
            ->get();
        return view('admin.bookings.result', [
            'count_patient' => $count_patients,
            'availed_service' => $availed_service,
            'confirmed' => $confirmed,
            'reschedule' => $reschedule,
            'cancelled' => $cancelled,
            'complete' => $complete,
            'noshow' => $noShow,
            'inputs' => $request,
            'providers' => $provider,
            'service' => $service,
            'details' => $details,
        ]);
    }
}
