<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Exports\AdminBookingExport;
use App\FamilyPlanTypeSubcategories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BookingController extends Controller
{
    public function indexes()
    {
        $services = FamilyPlanTypeSubcategories::where('is_approve', 1)->get();
        $clinics = DB::table('clinics')
            ->select('clinics.id', 'clinics.clinic_name')
            ->where('clinics.email', '<>', 'null')
            ->where('clinics.is_approve', '<>', 0)
            ->get();
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
            ->where('booking.service_id', $request['service_id'] ?? null)
            ->where('booking.status', '<>', 6)
            ->count();
        $selected_service = DB::table('family_plan_type_subcategory')->select('id', 'name')->where('id', $request['service_id'])->get();
        $selected_clinic = DB::table('clinics')->select('id', 'clinic_name')->where('id', $request['clinic_id'])->get();
        $selected_status = DB::table('status')->select('id', 'name')->where('id', $request['status'])->get();
        $availed_service = DB::table('booking')
            ->select('family_plan_type_subcategory.name as service',
                    DB::raw(' count(booking.id) as services_count'))
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->where('booking.clinic_id', $request['clinic_id'])
            ->where('booking.service_id', $request['service_id'] ?? null)
            ->where('booking.status', '<>', 6)
            ->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])
            ->groupBy(['family_plan_type_subcategory.name'])
            ->get();
        $confirmed = DB::table('booking')->select('id')->where('clinic_id', $request['clinic_id'])->Where('service_id', $request['service_id'] ?? null)->where('status', 1)->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])->count();
        $reschedule = DB::table('booking')->select('id')->where('clinic_id', $request['clinic_id'])->Where('service_id', $request['service_id'] ?? null)->where('status', 2)->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])->count();
        $cancelled = DB::table('booking')->select('id')->where('clinic_id', $request['clinic_id'])->Where('service_id', $request['service_id'] ?? null)->where('status', 3)->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])->count();
        $complete = DB::table('booking')->select('id')->where('clinic_id', $request['clinic_id'])->Where('service_id', $request['service_id'] ?? null)->where('status', 4)->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])->count();
        $noShow = DB::table('booking')->select('id')->where('clinic_id', $request['clinic_id'])->Where('service_id', $request['service_id'] ?? null)->where('status', 5)->whereBetween('booking.time_slot', [$request['date-from'], $request['date-to']])->count();
        $provider = DB::table('clinics')
            ->select('clinics.id', 'clinics.clinic_name')
            ->where('clinics.email', '<>', 'null')
            ->where('clinics.is_approve', '<>', 0)
            ->get();
        $service = DB::table('family_plan_type_subcategory')->select('id', 'name')->where('is_approve', 1)->get();

        $details = DB::table('booking')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('clinics', 'clinics.id', 'booking.clinic_id')
            ->leftJoin('status', 'booking.status', 'status.id')
            ->select('users.name', 'family_plan_type_subcategory.name as service_name', 'clinics.clinic_name', 'status.name as status', 'booking.time_slot as booked_date')
            ->where('booking.clinic_id', $request['clinic_id'])
            ->where('booking.service_id', $request['service_id'] ?? null)
            ->where('booking.status', $request['status'])
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
            'selected_service' => $selected_service,
            'selected_clinic' => $selected_clinic,
            'selected_status' => $selected_status,
        ]);
    }

    public function export()
    {
        $request = request()->all();
        $dateFrom = date('Y-m-d', strtotime($request['date_from']));
        $dateTo = date('Y-m-d', strtotime($request['date_to']));
        $fileName = 'Admin-Booking-Report-'.$dateFrom.'-to-'.$dateTo.'.csv';
        return Excel::download(new AdminBookingExport($dateFrom ?? '0000-00-00', $dateTo ?? '0000-00-00', $request['clinic'] ?? '0', $request['status'] ?? '0', $request['service'] ?? '0'), $fileName);
    }
}
