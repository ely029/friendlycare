<?php

declare(strict_types=1);

// @TB: https://laravel.com/docs/controllers#route-caching
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// @TB: https://laravel.com/docs/controllers#route-caching
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/cron', 'CronJobController@run');

// @TB: Do not remove these unless absolutely required. Removing will cause
// negative side-effect not limited to failed unit tests.
// To implement, set required config.boilerplate.firebase keys
Route::group([
    'prefix' => 'users',
    'namespace' => 'Users',
    'middleware' => ['auth.once'],
], static function () {
    // Normally done when (1) logging in, (2) device token changes.
    Route::post('/{user}/fcm_registration_tokens', 'FcmRegistrationTokensController@store');

    // Normally done when the user logs out
    Route::delete('/{user}/fcm_registration_tokens', 'FcmRegistrationTokensController@destroy');
});
//Patients
Route::post('/patients/register', 'Patients\DefaultController@register');
Route::post('/patients/login', 'Patients\DefaultController@login');
Route::get('/patients/users', 'Patients\DefaultController@getAllUsers');
Route::get('/patients/id/{id}', 'Patients\DefaultController@getUserById');
Route::post('/patients/update', 'Patients\DefaultController@update');
Route::get('/consentform', 'BasicPagesController@consentForm');
Route::post('/patients/verification', 'Patients\DefaultController@verification');
Route::post('/patients/reset', 'Patients\DefaultController@resetPassword');
Route::get('/patients/fpm/{id}', 'Patients\DefaultController@getFpmMethodsShow');
Route::post('/patients/fpm/{id}', 'Patients\DefaultController@createFpmShow');
Route::post('/patients/search', 'Patients\DefaultController@search');
Route::post('/patient/searchClinic', 'Patients\BookingController@searchClinic');
Route::get('/patient/selectedService/{id}', 'Patients\DefaultController@selectedService');
Route::post('/patient/postMethod/{id}', 'Patients\DefaultController@postMethod');
Route::post('/patient/postClinic/{id}', 'Patients\DefaultController@postClinic');
Route::get('/patient/viewClinic/{id}', 'Patients\DefaultController@viewClinicByPatient');
Route::get('/patient/viewClinic/', 'Patients\DefaultController@viewClinic');

//Basic Pages
Route::get('/basicpages/consent', 'BasicPagesController@consentForm');

//Booking
/**  Booking Flow 1: Booking Screen */
Route::get('/booking/bookingscreen/landingpage/{id}', 'Patients\BookingController@bookingLandingPage');
Route::get('/booking/bookingscreen/selectMethodPage', 'Patients\BookingController@selectMethodPage');
Route::post('/booking/bookingscreen/selectMethod/{id}', 'Patients\BookingController@postMethod');
Route::post('/booking/bookingscreen/clinicWithTaggedMethod/{id}', 'Patients\BookingController@searchClinicWithMethodTagged');
Route::post('/booking/bookingscreen/chooseClinic/{id}', 'Patients\BookingController@chooseClinic');
Route::post('/booking/bookingscreen/setupTime/{id}', 'Patients\BookingController@time');
Route::post('/booking/bookingscreen/postTime/{id}', 'Patients\BookingController@postTime');

/** Booking Flow 2: Clinic Directory */
Route::get('/booking/clinicDirectory/selectedClinic/{id}', 'Patients\BookingController@selectedClinic');
Route::post('/booking/clinicDirectory/postClinic/{id}', 'Patients\BookingController@postClinic');
Route::get('/booking/clinicDirectory/servicePage/{id}', 'Patients\BookingController@servicePage');
Route::post('/booking/clinicDirectory/servicePage/{id}', 'Patients\BookingController@postService');
Route::get('/bookings', 'Patients\BookingController@getAllBookings');

//Medical History
Route::post('/patient/medicalHistory/{id}/{questionid}', 'Patients\MedicalHistoryController@postMedicalHistory');
Route::get('/patient/medicalHistory/{id}/{questionid}', 'Patients\MedicalHistoryController@getPerPage');
Route::get('/patient/answers/medicalHistory/{id}', 'Patients\MedicalHistoryController@answer');

//Provider
Route::post('/provider/login', 'Provider\DefaultController@login');
Route::post('/provider/reset', 'Provider\DefaultController@resetPassword');
Route::get('/provider/staffs', 'Provider\DefaultController@getAllStaff');
Route::get('/provider/staffs/{id}', 'Provider\DefaultController@getUsersById');
Route::get('/provider/clinic/{id}', 'Provider\DefaultController@providerInfo');
Route::post('/provider/staff/update/{id}', 'Provider\DefaultController@update');
Route::get('/provider/description/{id}', 'Provider\DefaultController@getDescription');
Route::post('/provider/description/update/{id}', 'Provider\DefaultController@updateDescription');
Route::get('/provider/get/clinicHours/{id}', 'Provider\DefaultController@getClinicHours');
Route::get('/provider', 'Provider\DefaultController@getAllProviders');
Route::get('/provider/id/{id}', 'Provider\DefaultController@getAllProvidersById');
Route::post('/provider/clinichours/update/{id}', 'Provider\DefaultController@updateClinicHours');
Route::get('/provider/services/{id}', 'Provider\DefaultController@getServices');
Route::get('/provider/services', 'Provider\DefaultController@getAllServices');
Route::post('/provider/services/{id}', 'Provider\DefaultController@updateServices');
Route::get('/provider/galleries/{id}', 'Provider\DefaultController@getClinicGalleries');
Route::post('/provider/gallery/update/{id}', 'Provider\DefaultController@updateClinicGallery');
Route::get('/provider/paidservices/{id}', 'Provider\DefaultController@getPaidServices');
Route::post('/provider/paidservices/update/{id}', 'Provider\DefaultController@updatePaidService');
Route::get('/patient/fpmpage', 'Provider\DefaultController@getFPMDetails');
Route::get('/patient/fpmpage/{id}', 'Provider\DefaultController@fpmPagePerMethod');
Route::get('/fpm', 'Provider\DefaultController@getAllFPM');

//Provider Booking
Route::get('/booking/newrequest/provider/{id}', 'Patients\BookingController@getBooking');
Route::get('/booking/{id}', 'Patients\BookingController@getBookingPerId');
Route::post('/booking/approveBook/{id}', 'Patients\BookingController@approveBooking');

//API for dropdown province municipality and city
Route::get('/province/{id}', 'Patients\DefaultController@province');
Route::get('/city/{id}', 'Patients\DefaultController@city');
Route::get('/municipality/{id}', 'Patients\DefaultController@municipality');

//TimeSlot

Route::get('/booking/timeslot/{id}', 'Provider\DefaultController@getProviderTimeSlot');
Route::post('/booking/timeslot/{id}', 'Provider\DefaultController@postProviderTimeSlot');
