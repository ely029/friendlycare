<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Booking;
use App\BookingTime;
use App\Http\Controllers\Controller;
use App\Patients;
use App\PatientTimeSlot;
use App\Staffs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function bookingLandingPage($id)
    {
        $details = DB::table('medical_history_answer')
            ->select('updated_at')
            ->limit(1)
            ->where('patient_id', $id)
            ->get();

        return response([
            'name' => 'BookingLandingPage',
            'details' => $details,
        ]);
    }

    public function selectMethodPage()
    {
        $modernMethod = DB::table('family_plan_type_subcategory')
            ->select('id', 'name', 'short_name', 'family_plan_type_id', 'percent_effective', 'icon_url')
            ->where('is_approve', 1)
            ->where('family_plan_type_id', 1)
            ->get();

        $permanentMethod = DB::table('family_plan_type_subcategory')
            ->select('id', 'name', 'short_name', 'family_plan_type_id', 'percent_effective', 'icon_url')
            ->where('is_approve', 1)
            ->where('family_plan_type_id', 2)
            ->get();

        $naturalMethod = DB::table('family_plan_type_subcategory')
            ->select('id', 'name', 'short_name', 'family_plan_type_id', 'percent_effective', 'icon_url')
            ->where('is_approve', 1)
            ->where('family_plan_type_id', 3)
            ->get();

        return response([
            'name' => 'SelectAService',
            'modernMethod' => $modernMethod,
            'permanentMethod' => $permanentMethod,
            'naturalMethod' => $naturalMethod,
        ]);
    }

    public function postMethod(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        Booking::create([
            'patient_id' => $id,
            'service_id' => $obj['method'][0],
        ]);
        $details = DB::table('booking')
            ->select('service_id', 'patient_id', 'id as booking_id', 'clinic_id')
            ->where('patient_id', $id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->get();

        return response([
            'name' => 'postMethod',
            'details' => $details,
        ]);
    }

    public function searchClinic(Request $request)
    {
        $obj = json_decode($request->getContent(), true);

        if ($obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 1) {
            $details = DB::table('clinics')
                ->select('clinics.id', 'clinics.type', 'clinics.photo_url', 'clinics.clinic_name', 'clinics.city', 'clinics.paid_service as free_consultation', 'clinics.philhealth_accredited_1')
                ->Where('province', 'like', '%' . $obj['province'][0] . '%')
                ->Where('city', 'like', '%' . $obj['city'][0] . '%')
                ->Where('municipality', 'like', '%' . $obj['municipality'][0] . '%')
                ->Where('philhealth_accredited_1', 1)
                ->Where('paid_service', 0)
                ->where('clinics.user_id', 0)
                ->get();
        } elseif ($obj['philhealth_accredited'][0] === 1 && $obj['paid_service'][0] === 0) {
            $details = DB::table('clinics')
                ->select('clinics.id', 'clinics.type', 'clinics.photo_url', 'clinics.clinic_name', 'clinics.city', 'clinics.paid_service as free_consultation', 'clinics.philhealth_accredited_1')
                ->Where('province', 'like', '%' . $obj['province'][0] . '%')
                ->Where('city', 'like', '%' . $obj['city'][0] . '%')
                ->Where('municipality', 'like', '%' . $obj['municipality'][0] . '%')
                ->Where('philhealth_accredited_1', 1)
                ->Where('paid_service', 1)
                ->Where('paid_service', 0)
                ->where('clinics.user_id', 0)
                ->get();
        } elseif ($obj['philhealth_accredited'][0] === 0 && $obj['paid_service'][0] === 1) {
            $details = DB::table('clinics')
                ->select('clinics.id', 'clinics.type', 'clinics.photo_url', 'clinics.clinic_name', 'clinics.city', 'clinics.paid_service as free_consultation', 'clinics.philhealth_accredited_1')
                ->Where('province', 'like', '%' . $obj['province'][0] . '%')
                ->Where('city', 'like', '%' . $obj['city'][0] . '%')
                ->Where('municipality', 'like', '%' . $obj['municipality'][0] . '%')
                ->Where('philhealth_accredited_1', 1)
                ->Where('philhealth_accredited_1', 0)
                ->Where('paid_service', 0)
                ->where('clinics.user_id', 0)
                ->get();
        } else {
            $details = DB::table('clinics')
                ->select('clinics.id', 'clinics.type', 'clinics.photo_url', 'clinics.clinic_name', 'clinics.city', 'clinics.paid_service as free_consultation', 'clinics.philhealth_accredited_1')
                ->Where('province', 'like', '%' . $obj['province'][0] . '%')
                ->Where('city', 'like', '%' . $obj['city'][0] . '%')
                ->Where('municipality', 'like', '%' . $obj['municipality'][0] . '%')
                ->Where('philhealth_accredited_1', 'like', '%' . $obj['philhealth_accredited'][0] . '%')
                ->Where('paid_service', 'like', '%' . $obj['paid_service'][0] . '%')
                ->where('clinics.user_id', 0)
                ->get();
        }

        return response([
            'name' => 'searchClinic',
            'details' => $details,
        ]);
    }

    public function searchClinicWithMethodTagged(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        $getMethod = DB::table('booking')
            ->select('service_id', 'id')
            ->where('patient_id', $id)
            ->orderBy('id', 'desc')
            ->limit(1)
            ->pluck('service_id');

        if ($obj['philhealth_accredited'][0] === 1 && $obj['free_consultation'][0] === 1) {
            $clinic = DB::table('clinics')
                ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
                ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation')
                ->where('clinic_service.service_id', $getMethod[0])
                ->where('clinics.province', 'like', '%' . $obj['province'][0] . '%')
                ->Where('clinics.city', 'like', '%' . $obj['city'][0] . '%')
                ->Where('clinics.municipality', 'like', '%' . $obj['municipality'][0] . '%')
                ->Where('clinics.paid_service', 0)
                ->where('clinics.philhealth_accredited_1', 1)
                ->where('clinics.user_id', 0)
                ->get();
        } elseif ($obj['philhealth_accredited'][0] === 0 && $obj['free_consultation'][0] === 1) {
            $clinic = DB::table('clinics')
                ->join('clinic_service', 'clinic_service.clinic_id', 'clinics.id')
                ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation')
                ->where('clinic_service.service_id', $getMethod[0])
                ->where('clinics.province', 'like', '%' . $obj['province'][0] . '%')
                ->Where('clinics.city', 'like', '%' . $obj['city'][0] . '%')
                ->where('clinics.philhealth_accredited_1', 1)
                ->where('clinics.philhealth_accredited_1', 0)
                ->where('clinics.paid_service', 0)
                ->where('clinics.user_id', 0)
                ->get();
        } elseif ($obj['philhealth_accredited'][0] === 1 && $obj['free_consultation'][0] === 0) {
            $clinic = DB::table('clinic_service')
                ->join('clinics', 'clinic_service.clinic_id', 'clinics.id')
                ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation')
                ->distinct('clinics.clinic_name')
                ->where('clinic_service.service_id', $getMethod[0])
                ->where('clinics.province', 'like', '%' . $obj['province'][0] . '%')
                ->Where('clinics.city', 'like', '%' . $obj['city'][0] . '%')
                ->Where('clinics.municipality', 'like', '%' . $obj['municipality'][0] . '%')
                ->where('clinics.philhealth_accredited_1', 1)
                ->orWhere('clinics.paid_service', 1)
                ->where('clinics.user_id', 0)
                ->get();
        } else {
            $clinic = DB::table('clinic_service')
                ->join('clinics', 'clinic_service.clinic_id', 'clinics.id')
                ->select('clinics.id', 'clinics.clinic_name', 'clinics.city', 'clinics.type', 'clinics.philhealth_accredited_1', 'clinics.photo_url', 'clinics.paid_service as free_consultation')
                ->where('clinic_service.service_id', $getMethod[0])
                ->Where('clinics.province', 'like', '%' . $obj['province'][0] . '%')
                ->Where('clinics.city', 'like', '%' . $obj['city'][0] . '%')
                ->Where('clinics.municipality', 'like', '%' . $obj['municipality'][0] . '%')
                ->where('clinics.user_id', 0)
                ->distinct('clinics.clinic_name')
                ->orWhere('clinics.philhealth_accredited_1', 0)
                ->orWhere('clinics.philhealth_accredited_1', 1)
                ->orWhere('clinics.paid_service', 0)
                ->orWhere('clinics.paid_service', 1)
                ->get();
        }

        return response([
            'name' => 'postMethodWithTagged',
            'details' => $clinic,
        ]);
    }

    public function chooseClinic(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);

        DB::update('update booking set clinic_id = ? where patient_id = ? order by id desc limit 1', [$obj['clinic'][0], $id]);

        $getDetails = DB::table('booking')
            ->select('clinic_id', 'service_id', 'id')
            ->where('patient_id', $id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->get();

        return response([
            'name' => 'chooseClinic',
            'details' => $getDetails,
        ]);
    }

    public function time(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        //get the day
        $timestamp = strtotime($obj['date'][0]);
        $day = date('l', $timestamp);

        $getDetails = DB::table('booking')
            ->select('clinic_id')
            ->where('patient_id', $id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->pluck('clinic_id');

        $getStartTime = DB::table('clinic_hours')
            ->select('froms')
            ->where('days', $day)
            ->where('clinic_id', $getDetails[0])
            ->pluck('froms');

        $getEndTime = DB::table('clinic_hours')
            ->select('tos')
            ->where('days', $day)
            ->where('clinic_id', $getDetails[0])
            ->pluck('tos');

        $starttime = $getStartTime[0];  // your start time
        $endtime = $getEndTime[0];  // End time
        $duration = '30';  // split by 30 mins

        $array_of_time = [];
        $start_time = strtotime($starttime); //change to strtotime
        $end_time = strtotime($endtime); //change to strtotime

        $add_mins = $duration * 60;

        while ($start_time <= $end_time) { // loop between time
            $array_of_time[] = date('h:i A', $start_time);
            $start_time += $add_mins; // to check endtie=me
        }

        return response([
            'name' => 'setUpTime',
            'details' => $array_of_time,
        ]);
    }

    public function postTime(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);

        $getDetails = DB::table('booking')
            ->select('clinic_id', 'service_id', 'id')
            ->where('patient_id', $id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->pluck('id');

        $getClinicId = DB::table('booking')
            ->select('clinic_id')
            ->where('patient_id', $id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->pluck('clinic_id');

        $getSlot = PatientTimeSlot::where('clinic_id', $getClinicId[0])->first();
        $countPatient = DB::table('booking_time')
            ->select('booking_time.id')
            ->where('patient_id', $id)
            ->count();
        return $this->checkPatientCount($countPatient, $getSlot, $id, $getDetails, $obj);
    }

    public function selectedClinic($id)
    {
        $details = DB::table('clinics')
            ->leftJoin('paid_services', 'paid_services.clinic_id', 'clinics.id')
            ->select('clinics.id', 'paid_services.id as free_consultation', 'clinics.photo_url', 'clinics.clinic_name', 'clinics.street_address', 'clinics.type', 'clinics.philhealth_accredited_1')
            ->where('clinics.id', $id)
            ->get();

        return response([
            'name' => 'SelectedClinic',
            'details' => $details,
        ]);
    }

    public function postClinic(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        Booking::create([
            'patient_id' => $id,
            'clinic_id' => $obj['clinic'][0],
        ]);

        $details = DB::table('booking')
            ->select('clinic_id', 'patient_id')
            ->where('patient_id', $id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->get();

        return response([
            'name' => 'postClinic',
            'details' => $details,
        ]);
    }
    public function servicepage($id)
    {
        $getDetails = DB::table('booking')
            ->select('clinic_id', 'service_id', 'id')
            ->where('patient_id', $id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->pluck('clinic_id');

        $modernMethod = DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.id', 'name', 'short_name', 'type', 'percent_effective', 'icon_url')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->where('clinics.id', $getDetails[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 1)
            ->get();

        $permanentMethod = DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.id', 'name', 'short_name', 'type', 'percent_effective', 'icon_url')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->where('clinics.id', $getDetails[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 2)
            ->get();

        $naturalMethod = DB::table('family_plan_type_subcategory')
            ->select('family_plan_type_subcategory.id', 'name', 'short_name', 'type', 'percent_effective', 'icon_url')
            ->join('clinic_service', 'clinic_service.service_id', 'family_plan_type_subcategory.id')
            ->join('clinics', 'clinics.id', 'clinic_service.clinic_id')
            ->where('clinics.id', $getDetails[0])
            ->where('family_plan_type_subcategory.family_plan_type_id', 3)
            ->get();

        return response([
            'name' => 'ServicePage',
            'modernMethod' => $modernMethod,
            'permanentMethod' => $permanentMethod,
            'naturalMethod' => $naturalMethod,
        ]);
    }

    public function postService(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        DB::update('update booking set service_id = ? where patient_id = ? order by id desc limit 1', [$obj['method'][0], $id]);
    }

    public function getAllBookings()
    {
        $details = Booking::where(['is_booked' => 1])->get();

        return response([
            'name' => 'Bookings',
            'details' => $details,
        ]);
    }

    public function getNewRequestBooking($id)
    {
        $clinic = Staffs::where('user_id', $id)->pluck('clinic_id');
        $booking = new Booking();
        $details = $booking->getNewRequestBooking($clinic[0]);

        return response([
            'name' => 'NewRequestBooking',
            'details' => $details,
        ]);
    }

    public function getBookings($id)
    {
        $clinic = Staffs::where('user_id', $id)->pluck('clinic_id');
        $booking = new Booking();
        $date = date('Y-m-d');
        $details = $booking->getBookings($clinic[0], $date);

        return response([
            'name' => 'BookingsToday',
            'details' => $details,
        ]);
    }

    public function getBookingsYesterday($id)
    {
        $clinic = Staffs::where('user_id', $id)->pluck('clinic_id');
        $booking = new Booking();
        $date = date('Y-m-d', strtotime('-1 days'));
        $details = $booking->getBookingsYesterday($clinic[0], $date);

        return response([
            'name' => 'BookingsYesterday',
            'details' => $details,
        ]);
    }

    public function getBookingsTommorow($id)
    {
        $clinic = Staffs::where('user_id', $id)->pluck('clinic_id');
        $booking = new Booking();
        $date = date('Y-m-d', strtotime('+1 days'));
        $details = $booking->getBookingsTommorow($clinic[0], $date);

        return response([
            'name' => 'BookingsTommorow',
            'details' => $details,
        ]);
    }

    public function getBookingPerId($id)
    {
        Booking::where('id', $id)->update([
            'is_read' => 0,
        ]);

        $booking = new Booking();
        $details = $booking->getBookingById($id);

        return response([
            'name' => 'BookingPerBookingId',
            'details' => $details,
        ]);
    }

    public function bookingsDatePicker(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        $clinic = Staffs::where('user_id', $id)->pluck('clinic_id');
        $booking = new Booking();
        $details = $booking->bookingsDatePicker($clinic[0], $obj);

        return response([
            'name' => 'BookingsDatePicker',
            'details' => $details,
        ]);
    }

    public function approveBooking(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        DB::update('update booking set status = ? where id = ?', [1, $id]);
        DB::update('update booking_time set status = ? where time_slot = ?', [1, $obj['time_slot'][0]]);
        BookingTime::where(['booking_id' => $id, 'status' => null])->delete();
        $data = Booking::where('id', $id)->get();

        return response([
            'name' => 'BookApproved',
            'message' => 'Book Approved!',
            'data' => $data,
        ]);
    }

    public function cancellationDetails($id)
    {
        $booking = new Booking();
        $details = $booking->cancellationDetails($id);

        return response([
            'name' => 'CancellationDetails',
            'details' => $details,
        ]);
    }

    public function approveCancellationDetails(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        DB::update('update booking set cancellation_message_1 = ?, status = ? where id = ?', [$obj['cancellation_message'][0], 3, $id]);
        DB::update('update booking_time set status = ? where booking_id = ?', [3, $id]);
        return response([
            'name' => 'ApproveCancellation',
            'message' => 'This booking is cancelled',
        ]);
    }

    public function getConfirmServiceDetails($id)
    {
        $booking = new Booking();
        $details = $booking->getConfirmServiceDetails($id);

        return response([
            'name' => 'confirmServiceDetails',
            'details' => $details,
        ]);
    }

    public function postConfirmService(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        DB::update('update booking set service_id = ? where id = ?', [$obj['service'][0], $id]);

        return response([
            'name' => 'postConfirmService',
            'message' => 'service confirmed!',
        ]);
    }

    public function bookings()
    {
        return DB::table('booking')
            ->select('id', 'service_id', 'clinic_id', 'time_slot', 'is_cancelled', 'is_approved', 'patient_id', 'referal', 'is_booked', 'no_show', 'status', 'is_read')
            ->get();
    }

    private function checkPatientCount($countPatient, $getSlot, $id, $getDetails, $obj)
    {
        if ($countPatient >= $getSlot->number_of_slot) {
            return response([
                'message' => 'Number of Patient in this clinic is exceeded. Choose another clinic or method. Thank you',
            ], 422);
        }
        for ($eee = 0; $eee <= 100; $eee++) {
            BookingTime::create([
                'patient_id' => $id,
                'booking_id' => $getDetails[0],
                'time_slot' => $obj['time'][$eee],
            ]);
        }
        return response([
            'response' => 'Booking Created Succesfully',
        ]);
    }
}
