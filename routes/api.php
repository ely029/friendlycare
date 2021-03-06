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
Route::post('/patients/verification', 'Patients\DefaultController@verification');
Route::post('/patients/reset', 'Patients\DefaultController@resetPassword');
Route::get('/patients/fpm/{id}', 'Patients\DefaultController@getFpmMethodsShow');
Route::post('/patients/fpm/{id}', 'Patients\DefaultController@createFpmShow');
Route::post('/patients/search', 'Patients\DefaultController@search');
Route::post('/patient/searchClinic/{id}', 'Patients\BookingController@searchClinic');
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
Route::get('/bookingtime', 'Patients\BookingController@bookingTime');

//Medical History
Route::post('/patient/medicalHistory/{id}/{questionid}', 'Patients\MedicalHistoryController@postMedicalHistory');
Route::get('/patient/medicalHistory/{id}/{questionid}', 'Patients\MedicalHistoryController@getPerPage');
Route::get('/patient/answers/medicalHistory/{id}', 'Patients\MedicalHistoryController@answer');

//Provider
Route::post('/provider/login', 'Provider\DefaultController@login');
Route::post('/provider/reset', 'Provider\DefaultController@resetPassword');
Route::get('/provider/staffs', 'Provider\DefaultController@getAllStaff');
Route::get('/provider/staffs/{id}', 'Provider\DefaultController@getUsersById');
Route::get('/provider/clinics/{id}', 'Provider\DefaultController@getUsersByClinics');
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
Route::get('/booking/newrequest/provider/{id}', 'Patients\BookingController@getNewRequestBooking');
Route::get('/booking/bookingstoday/provider/{id}', 'Patients\BookingController@getBookings');
Route::get('/booking/bookingsyesterday/provider/{id}', 'Patients\BookingController@getBookingsYesterday');
Route::get('/booking/bookingstommorow/provider/{id}', 'Patients\BookingController@getBookingsTommorow');
Route::post('/booking/bookingsdatepicker/provider/{id}', 'Patients\BookingController@bookingsDatePicker');
Route::get('/booking/{id}', 'Patients\BookingController@getBookingPerId');
Route::post('/booking/approveBook/{id}', 'Patients\BookingssController@approveBooking');

//Provider cancellation
Route::get('/booking/cancellation/provider/{id}', 'Patients\BookingController@cancellationDetails');
Route::post('/booking/cancellation/provider/{id}', 'Patients\BookingssController@approveCancellationDetails');

//Provider Confirm Service
Route::get('/booking/confirmService/provider/{id}', 'Patients\BookingController@getConfirmServiceDetails');
Route::post('/booking/confirmService/provider/{id}', 'Patients\BookingController@postConfirmService');
Route::get('/booking/clinicservice/{id}', 'Patients\BookingController@getClinicServiceByClinic');

//Provider Reschedule
Route::get('/booking/reschedule/provider/{id}', 'Patients\BookingController@getRescheduleDetails');
Route::post('/booking/reschedule/setupTime/{id}', 'Patients\BookingController@rescheduleTimeSetUp');
Route::post('/booking/reschedule/createReschedule/{id}', 'Patients\BookingssController@createReschedule');

//Patient Reschedule
Route::post('/patient/cancellationbooking/{id}', 'Patients\NotificationsController@postCancellation');

//Provider Holiday Management
Route::get('/holidaymanagement/{id}', 'Provider\DefaultController@getHolidayManagementDetails');
Route::post('/holidaymanagement/{id}', 'Provider\DefaultController@holidayManagementPost');
Route::post('/holidaymanagement/delete/{id}', 'Provider\DefaultController@holidayManagementDeleteHoliday');
Route::post('/holidaymanagement/savechanges/{id}', 'Provider\DefaultController@holidaySaveChanges');
Route::get('/holidaymanagement/showcreatedHoliday/{id}', 'Provider\DefaultController@showCreatedHoliday');
Route::post('/holidaymanagement/deletecreatedHoliday/{id}', 'Provider\DefaultController@deleteCreatedHoliday');
//Patient Inbox
Route::get('/patient/inbox/{id}', 'Patients\BookingsController@getInboxDetails');
Route::get('/patient/inbox/booking/{id}', 'Patients\BookingsController@getInboxPerBooking');
Route::post('/patient/inbox/filter/{id}', 'Patients\BookingsController@filterPerStatus');

//API for dropdown province municipality and city
Route::get('/province/{id}', 'Patients\DefaultController@province');
Route::get('/province', 'Patients\DefaultController@provinceWithOutMethod');
Route::get('/city/{province}', 'Patients\DefaultController@city');
Route::get('/municipality/{id}', 'Patients\DefaultController@municipality');

//Basic Pages
Route::get('/consentform', 'BasicPagesController@consentForm');
Route::get('/consentformsection', 'BasicPagesController@consentFormSection');
Route::get('/aboutus', 'BasicPagesController@aboutUs');
Route::get('/termsandconditionpatient', 'BasicPagesController@termsOfServicePatient');
Route::get('/termsandconditionprovider', 'BasicPagesController@termsOfServiceProvider');
//TimeSlot

Route::get('/booking/timeslot/{id}', 'Provider\DefaultController@getProviderTimeSlot');
Route::post('/booking/timeslot/{id}', 'Provider\DefaultController@postProviderTimeSlot');

Route::get('/checkdatetoday', 'Patients\BookingController@checkDateToday');

//Notifications
Route::get('/patient/notifications/{id}', 'Patients\NotificationsController@getNotifications');
Route::get('/notifications/patient/{id}', 'Patients\NotificationsController@notificationDetails');
Route::get('/notifications/patient', 'Patients\NotificationsController@notifications');

//Patient Rating
Route::get('/rating/{id}', 'Patients\RatingController@getRatingDetails');
Route::post('/rating', 'Patients\RatingController@postRating');
Route::get('/rating', 'Patients\RatingController@rating');
Route::get('/ratingdetails', 'Patients\RatingController@ratingDetails');
Route::post('/notifications/patient/filter/{id}', 'Patients\NotificationsController@filter');

//Provider Rating
Route::get('/rating/provider/{id}', 'Provider\RatingController@getDetails');
Route::get('/rating/provider/clinic/{id}', 'Provider\RatingController@getRatingAverage');
Route::post('/rating/filter/provider/{id}', 'Provider\RatingController@filter');

//chatbot
Route::get('/chatbot/index/{id}', 'Patients\ChatBotManagementController@index');
Route::get('/chatbot/index/choices/{id}', 'Patients\ChatBotManagementController@choices');
Route::get('/chatbot/responses/{id}', 'Patients\ChatBotManagementController@responses');

//provider notifications
Route::get('/notifications/provider/{id}', 'Provider\NotificationsController@getNotifications');
Route::get('/notifications/provider/details/{id}', 'Provider\NotificationsController@getDetails');
Route::get('/notifications/provider/badge/{id}', 'Provider\NotificationsController@badge');

//survey push notification
Route::get('/patient/survey/pushnotification/{id}', 'Patients\SurveyController@index');

//Survey Push Notification for Events (scheduled)
Route::get('/patient/events/scheduled/{id}', 'Patients\NotificationsController@scheduledEvents');
//push notification for events
Route::get('/patient/events/pushnotification/{id}', 'Patients\NotificationsController@index');

//push notification for scheduled booking tommorow
Route::get('/patient/booking/tommorow/pushnotification/{id}', 'Patients\NotificationsController@bookingTommorow');
//push notification for provider scheduled booking tommorow
Route::get('/provider/booking/tommorow/pushnotification/{id}', 'Patients\NotificationsController@providerBookingTommorow');
//provider notification
Route::get('/providerNotifications', 'Provider\NotificationsController@getAllProviderNotification');

//provider report
Route::post('/provider/reports/header/{id}', 'Provider\ReportsController@header');
Route::post('/provider/reports/availableservice/{id}', 'Provider\ReportsController@availableServices');
Route::post('/provider/reports/status/{id}', 'Provider\ReportsController@status');
Route::post('/provider/reports/details/{id}', 'Provider\ReportsController@details');
Route::get('/provider/export/{id}', 'Provider\ReportsController@export');

//Provider upcoming booking email notification
Route::get('/provider/upcomingbooking/{id}', 'Provider\NotificationsController@upcomingBookingEmailNotif');

//patient family planning page
Route::get('/patient/fpm/{pageid}/{id}', 'Patients\FPMController@pages');
Route::post('/patient/fpm/{pageid}/{id}', 'Patients\FPMController@post');
Route::get('/fpmtypeservice', 'Patients\FPMController@fpmType');

//patient Ads Management
Route::get('/ads/patient', 'Patients\AdsManagementController@display');
Route::get('/ads/click/{id}', 'Patients\AdsManagementController@clickAds');
Route::get('/ads/views/{id}', 'Patients\AdsManagementController@viewAds');

Route::get('/clinicservice', 'Provider\DefaultController@getClinicService');
Route::get('/providerNotifications', 'Patients\BookingssController@providerNotifications');
Route::get('/logout/{id}', 'Provider\DefaultController@logout');
Route::get('/chatbot', 'Provider\DefaultController@chatBot');
Route::get('/chatbotresponse', 'Provider\DefaultController@chatBotResponse');
