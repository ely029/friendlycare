<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Booking;
use App\BookingTime;
use App\Classes\SearchClinicWithOutProvinceandCity;
use App\Classes\SearchClinicWithProvinceAndCity;
use App\Classes\TaggedMethodWithoutProvinceAndCity;
use App\Classes\TaggedMethodWithProvinceAndCity;
use App\Clinics;
use App\ClinicService;
use App\ClinicTime;
use App\EventsNotification;
use App\FamilyPlanTypeSubcategories;
use App\FpmTypeService;
use App\Http\Controllers\Controller;
use App\PatientTimeSlot;
use App\Staffs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

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
        $fpm = new FamilyPlanTypeSubcategories();
        $modernMethod = $fpm->selectMethodPageModern();
        $permanentMethod = $fpm->selectMethodPagePermanent();
        $naturalMethod = $fpm->selectMethodPageNatural();

        return response([
            'name' => 'SelectAService',
            'modernMethod' => $modernMethod,
            'permanentMethod' => $permanentMethod,
            'naturalMethod' => $naturalMethod,
        ]);
    }

    public function postMethod(Request $request, $id)
    {
        $booking = new Booking();
        $obj = json_decode($request->getContent(), true);
        Booking::create([
            'patient_id' => $id,
            'service_id' => $obj['method'][0],
        ]);
        $details = $booking->getDetailsPostMethod($id);

        return response([
            'name' => 'postMethod',
            'details' => $details,
        ]);
    }

    public function searchClinic(Request $request)
    {
        $clinic = new Clinics();
        $obj = json_decode($request->getContent(), true);
        if ($obj['province'][0] === '' && $obj['city'][0] === '') {
            $class = new SearchClinicWithOutProvinceandCity();
            $clinic = $class->searchClinic($obj);
        } else {
            $class = new SearchClinicWithProvinceandCity();
            $clinic = $class->searchClinic($obj);
        }
        return response([
            'name' => 'searchClinic',
            'details' => $clinic,
        ]);
    }

    public function searchClinicWithMethodTagged(Request $request, $id)
    {
        $booking = new Booking();
        $obj = json_decode($request->getContent(), true);
        $booking->getMethod($id);

        if ($obj['province'][0] === '' && $obj['city'][0] === '') {
            $class = new TaggedMethodWithoutProvinceAndCity();
            $clinic = $class->index($obj);
        } else {
            $class = new TaggedMethodWithProvinceAndCity();
            $clinic = $class->index($obj);
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
        $getClinicId = DB::table('booking')
            ->select('clinic_id')
            ->where('patient_id', $id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->pluck('clinic_id');

        $checkDate = DB::table('holiday')->select('holiday.id')->where('date', $obj['date'][0])->where('clinic_id', $getClinicId[0])->count();

        if ($checkDate >= 1) {
            return response([
                'message' => 'The clinic on the date you set is on holiday. Please choose another date',
            ], 422);
        }
        $timestamp = strtotime($obj['date'][0]);
        $day = date('l', $timestamp);

        $getDetails = DB::table('booking')
            ->select('clinic_id')
            ->where('patient_id', $id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->pluck('clinic_id');
        $times = [];
        $clinicTime = new ClinicTime();
        $time = $clinicTime->getTime($getDetails[0], $day);
        $data = json_decode(json_encode($time), true);
        foreach ($data as $datas) {
            $times[] = $datas['time'];
        }
        return response([
            'name' => 'setUpTime',
            'details' => $times,
        ]);
    }

    public function postTime(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);

        $getClinicId = DB::table('booking')
            ->select('clinic_id')
            ->where('patient_id', $id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->pluck('clinic_id');

        return $this->checkPatientCount($id, $getClinicId, $obj);
    }

    public function selectedClinic($id)
    {
        $clinics = new Clinics();
        $details = $clinics->getSelectedClinic($id);

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
        $fpm = new FamilyPlanTypeSubcategories();
        $getDetails = DB::table('booking')
            ->select('clinic_id', 'service_id', 'id')
            ->where('patient_id', $id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->pluck('clinic_id');

        $modernMethod = $fpm->getFPMModernServicePage($getDetails);
        $permanentMethod = $fpm->getFPMPermanentServicePage($getDetails);
        $naturalMethod = $fpm->getFPMNaturalServicePage($getDetails);

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
        $details = Booking::all();

        return response([
            'name' => 'Bookings',
            'details' => $details,
        ]);
    }

    public function getNewRequestBooking($id)
    {
        $clinic = Staffs::where('user_id', $id)->pluck('clinic_id');
        $booking = new Booking();
        $timenow = strtotime(date('Y-m-d H:i'));
        DB::update('update booking set status = 5 where new_request_end_time <='.$timenow.' and is_approved = 1');
        $endTime = DB::table('booking')->select('time_from', 'time_to')->where('clinic_id', $clinic[0])->get();
        $this->checkNoShow($clinic, $endTime);
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
        $timenow = strtotime(date('Y-m-d H:i'));
        DB::update('update booking set status = 5 where end_time <='.$timenow.' and is_approved = 1 and (status = 1 or status = 2 or status = 4)');
        $date = date('Y-m-d');
        $details = $booking->getBookings($clinic[0], $date);

        return response([
            'name' => 'BookingsToday',
            'details' => $details,
        ]);
    }

    public function checkDateToday()
    {
        return date('Y-m-d');
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

    public function cancellationDetails($id)
    {
        $booking = new Booking();
        $details = $booking->cancellationDetails($id);

        return response([
            'name' => 'CancellationDetails',
            'details' => $details,
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
        DB::update('update booking set service_id = ?, status = ? where id = ?', [$obj['service'][0], 4, $id]);
        $getClinicId = DB::table('booking')->select('clinic_id')->where('id', $id)->pluck('clinic_id');
        $getClinicName = DB::table('clinics')->select('clinic_name')->where('id', $getClinicId[0])->pluck('clinic_name');
        $getPatientId = DB::table('booking')->select('patient_id')->where('id', $id)->pluck('patient_id');
        $getServiceId = DB::table('booking')->select('service_id')->where('id', $id)->pluck('service_id');
        $message = $getClinicName[0];
        DB::delete('delete from fpm_type_service where patient_id = ?',[$getPatientId[0]]);
        FpmTypeService::create([
            'service_id' => $getServiceId[0],
            'patient_id' => $getPatientId[0],
        ]);
        $getClinicEmail = DB::table('clinics')->select('email')->where('id', $getClinicId[0])->pluck('email');
        Mail::send('email.patient.provider.provider-complete-booking', [], function ($mail) use ($getClinicEmail) {
            $mail->from('notifications@friendlycare.com');
            $mail->to($getClinicEmail[0], 'Provider')->subject('Booking Completed');
        });
        EventsNotification::create([
            'patient_id' => $getPatientId[0],
            'message' => $message,
            'clinic_name_1' => 'ddd',
            'display_type' => 'Notifications',
            'title' => 'Booking Confirmed and Completed',
            'status' => 4,
            'booking_id' => $id,
        ]);
        $user = DB::table('users')->select('fcm_notification_key')->where('id', $getPatientId[0])->pluck('fcm_notification_key');
        $fcmurl = 'https://fcm.googleapis.com/fcm/send';
        $token = $user[0];
        $notification = [
            'title' => 'Booking Completed',
            'body' => 'Your Booking is now Completed',
            'icon' => 'myIcon',
            'sound' => 'defaultSound',
            'priority' => 'high',
            'contentAvailable' => true,
        ];
        $extraNotifications = ['message' => $notification, 'moredata' => 'bb'];
        $fcmNotification = [
            'to' => $token,
            'notification' => $notification,
            'data' => $extraNotifications,
        ];
        $headers = [
            'Authorization: key='.\Config::get('boilerplate.firebase.server_key').'',
            'Content-Type: application/json',
        ];
        $chh = curl_init();
        curl_setopt($chh, CURLOPT_URL, $fcmurl);
        curl_setopt($chh, CURLOPT_POST, true);
        curl_setopt($chh, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chh, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chh, CURLOPT_SSL_VERIFYPEER, $headers);
        curl_setopt($chh, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($chh);
        curl_close($chh);

        return response([
            'name' => 'postConfirmService',
            'message' => 'service confirmed!',
            'details' => $result,
        ]);
    }

    public function bookings()
    {
        return DB::table('booking')
            ->select('id', 'service_id', 'clinic_id', 'time_slot', 'is_cancelled', 'is_approved', 'patient_id', 'referal', 'is_booked', 'no_show', 'status', 'is_read')
            ->get();
    }

    public function bookingTime()
    {
        return BookingTime::all();
    }

    public function getRescheduleDetails($id)
    {
        $booking = new Booking();
        $details = $booking->getRescheduleDetails($id);

        return response([
            'name' => 'rescheduleDetails',
            'details' => $details,
        ]);
    }

    public function rescheduleTimeSetUp(Request $request, $id)
    {
        $obj = json_decode($request->getContent(), true);
        //get the day
        $timestamp = strtotime($obj['date'][0]);
        $day = date('l', $timestamp);

        $getClinicId = DB::table('staffs')
            ->select('clinic_id')
            ->where('user_id', $id)
            ->pluck('clinic_id');

        $checkDate = DB::table('holiday')->select('holiday.id')->where('date', $obj['date'][0])->where('clinic_id', $getClinicId[0])->count();

        if ($checkDate >= 1) {
            return response([
                'message' => 'The clinic on the date you set is on holiday. Please choose another date',
            ], 422);
        }

        $getDetails = DB::table('staffs')
            ->select('clinic_id')
            ->where('user_id', $id)
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
            'name' => 'rescheduleSetUpTime',
            'details' => $array_of_time,
        ]);
    }
    public function getClinicServiceByClinic($id)
    {
        $getClinicId = DB::table('staffs')->select('clinic_id')->where('user_id', $id)->pluck('clinic_id');
        $clinicservice = new ClinicService();
        $details = $clinicservice->getServices($getClinicId[0]);

        return response([
            'name' => 'getClinicService',
            'details' => $details,
        ]);
    }
    private function insertBookings($string_end_time, $string_start_time, $clinic)
    {
        if ($string_end_time >= $string_start_time) {
            Booking::where('clinic_id', $clinic[0])->update([
                'status' => 5,
            ]);
        }
    }

    private function checkPatientCount($id, $getClinicId, $obj)
    {
        $booking = new Booking();
        $timeSlot = new PatientTimeSlot();
        $checkBooking = $booking->checkBooking($getClinicId[0], $obj);
        $getSlot = $timeSlot->getSlot($getClinicId[0]);
        if ($getSlot[0] <= $checkBooking) {
            return response()->json('The time you choose are already full. please choose another time.', 422);
        }
        DB::update('update booking set time_slot = ?, status = ? where patient_id = ? order by id desc limit 1', [$obj['date'][0], 6, $id]);
        $this->createBookingTime($id, $obj);
        return response([
            'response' => 'Booking Created Succesfully',
        ], 200);
    }

    private function createBookingTime($id, $obj)
    {
        $getDetails = DB::table('booking')
            ->select('clinic_id', 'service_id', 'id')
            ->where('patient_id', $id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->pluck('id');

        BookingTime::create([
            'patient_id' => $id,
            'time_slot' => $obj['time'][0],
            'booking_id' => $getDetails[0],
        ]);
    }

    private function checkNoShow($clinic, $endTime)
    {
        foreach ($endTime as $end) {
            if (isset($end->time_start) && isset($end->time_to)) {
                $end_time = $end->time_to;
                $start_time = $end->time_start;
                $string_end_time = strtotime($end_time);
                $string_start_time = strtotime($start_time);

                $this->insertBookings($string_end_time, $string_start_time, $clinic);
            }
        }
    }
}
