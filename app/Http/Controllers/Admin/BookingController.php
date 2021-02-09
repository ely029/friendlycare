<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Classes\CountPatient;
use App\Classes\DisplayDetails;
use App\Classes\GetCancelledStatus;
use App\Classes\GetCompletedStatus;
use App\Classes\GetConfirmedStatus;
use App\Classes\GetNoShowStatus;
use App\Classes\GetRescheduledStatus;
use App\Clinics;
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
        $clinic = new Clinics();
        $fpm = new FamilyPlanTypeSubcategories();
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
        $selected_service = $fpm->getSelectedService($request);
        $selected_clinic = DB::table('clinics')->select('id', 'clinic_name')->where('id', $request['clinic_id'])->get();
        $selected_status = DB::table('status')->select('id', 'name')->where('id', $request['status'])->get();
        $availed_service = $booking->getAvailedService($request, $dateFrom, $dateTo);
        $confirmed = $this->getConfirmedStatus($request);
        $reschedule = $this->getRescheduleStatus($request);
        $cancelled = $this->getCancelledStatus($request);
        $complete = $this->getCompleteStatus($request);
        $noShow = $this->getNoShowStatus($request);
        $provider = $clinic->getProvider();
        $service = DB::table('family_plan_type_subcategory')->select('id', 'name')->where('is_approve', 1)->get();
        $details = $this->displayDetails($request, $dateFrom, $dateTo);
        $count_patients = $this->countPatients($request, $dateFrom, $dateTo);
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
        $validator = \Validator::make(request()->all(), [
            'date-from' => 'required',
            'date-to' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('booking/index')
                ->withErrors($validator)
                ->withInput();
        }
        $dateFrom = date('Y-m-d', strtotime($request['date_from']));
        $dateTo = date('Y-m-d', strtotime($request['date_to']));
        $fileName = 'Admin-Booking-Report-'.$dateFrom.'-to-'.$dateTo.'.csv';
        return Excel::download(new AdminBookingExport($dateFrom ?? '0000-00-00', $dateTo ?? '0000-00-00', $request['clinic'] ?? '0', $request['status'] ?? '0', $request['service'] ?? '0'), $fileName);
    }

    private function getConfirmedStatus($request)
    {
        $class = new GetConfirmedStatus();
        return $class->index($request);
    }

    private function getRescheduleStatus($request)
    {
        $class = new GetRescheduledStatus();
        return $class->index($request);
    }

    private function getCancelledStatus($request)
    {
        $class = new GetCancelledStatus();
        return $class->index($request);
    }

    private function getCompleteStatus($request)
    {
        $class = new GetCompletedStatus();
        return $class->index($request);
    }

    private function getNoShowStatus($request)
    {
        $class = new GetNoShowStatus();
        return $class->index($request);
    }

    private function countPatients($request, $dateFrom, $dateTo)
    {
        $booking = new Booking();
        if ($request['clinic_id'] !== null && $request['service_id'] !== null && $request['status'] !== null) {
            return $booking->countPatientSixthScenario($request, $dateFrom, $dateTo);
        }

        $class = new CountPatient();
        return $class->index($request, $dateFrom, $dateTo);
    }

    private function displayDetails($request, $dateFrom, $dateTo)
    {
        $booking = new Booking();
        if ($request['clinic_id'] !== null && $request['service_id'] !== null && $request['status'] !== null) {
            return $booking->displayCountSixthScenario($request, $dateFrom, $dateTo);
        }
        $class = new DisplayDetails();
        return $class->index($request, $dateFrom, $dateTo);
    }
}
