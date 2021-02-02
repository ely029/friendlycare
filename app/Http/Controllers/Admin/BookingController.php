<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Booking;
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
        $booking = new Booking();
        $validator = \Validator::make(request()->all(), [
            'date-from' => 'required',
            'date-to' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('booking/index')
                ->withErrors($validator)
                ->withInput();
        }
        $dateFrom = date('Y-m-d', strtotime($request['date-from']));
        $dateTo = date('Y-m-d', strtotime($request['date-to']));
        $this->displayDetails($request, $dateFrom, $dateTo);
        $selected_service = DB::table('family_plan_type_subcategory')->select('id', 'name')->where('id', $request['service_id'])->get();
        $selected_clinic = DB::table('clinics')->select('id', 'clinic_name')->where('id', $request['clinic_id'])->get();
        $selected_status = DB::table('status')->select('id', 'name')->where('id', $request['status'])->get();
        $availed_service = DB::table('booking')
            ->select('family_plan_type_subcategory.name as service',
                    DB::raw(' count(booking.id) as services_count'))
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->where('booking.clinic_id', $request['clinic_id'] ?? null)
            ->where('booking.service_id', $request['service_id'] ?? null)
            ->where('booking.status', '<>', 6)
            ->whereBetween('booking.time_slot', [$dateFrom, $dateTo])
            ->groupBy(['family_plan_type_subcategory.name'])
            ->get();
        $confirmed = $booking->getConfirmedStatus($request);
        $reschedule = $booking->getRescheduledStatus($request);
        $cancelled = $booking->getCancelledStatus($request);
        $complete = $booking->getCompleteStatus($request);
        $noShow = $booking->getNoShowStatus($request);
        $provider = DB::table('clinics')
            ->select('clinics.id', 'clinics.clinic_name')
            ->where('clinics.email', '<>', 'null')
            ->where('clinics.is_approve', '<>', 0)
            ->get();
        $service = DB::table('family_plan_type_subcategory')->select('id', 'name')->where('is_approve', 1)->get();
        $details = $this->displayDetails($request, $dateFrom, $dateTo);
        $count_patients = 0;
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

    private function displayDetails($request, $dateFrom, $dateTo)
    {
        $booking = new Booking();
        if ($request['clinic_id'] === null && $request['service_id'] === null && $request['status'] === null) {
            return $booking->displayCountFirstScenario($dateFrom, $dateTo);
        }
        if ($request['clinic_id'] === null && $request['service_id'] === null && $request['status'] !== null) {
            return $booking->displayCountSecondScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] === null && $request['service_id'] !== null && $request['status'] !== null) {
            return $booking->displayCountThirdScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] !== null && $request['service_id'] === null && $request['status'] !== null) {
            return $booking->displayCountFourthScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] !== null && $request['service_id'] !== null && $request['status'] === null) {
            return $booking->displayCountFifthScenario($request, $dateFrom, $dateTo);
        }
        if ($request['clinic_id'] !== null && $request['service_id'] !== null && $request['status'] !== null) {
            return $booking->displayCountSixthScenario($request, $dateFrom, $dateTo);
        }
        return DB::table('booking')
            ->leftJoin('users', 'users.id', 'booking.patient_id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'booking.service_id')
            ->leftJoin('clinics', 'clinics.id', 'booking.clinic_id')
            ->leftJoin('status', 'booking.status', 'status.id')
            ->select('users.name', 'family_plan_type_subcategory.name as service_name', 'clinics.clinic_name', 'status.name as status', 'booking.time_slot as booked_date')
            ->where('booking.clinic_id', $request['clinic_id'] ?? null)
            ->where('booking.service_id', $request['service_id'] ?? null)
            ->where('booking.status', $request['status'] ?? null)
            ->whereBetween('booking.time_slot', [$dateFrom, $dateTo])
            ->get();
    }
}
