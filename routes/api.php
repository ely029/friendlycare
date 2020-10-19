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

//Basic Pages
Route::get('/basicpages/consent', 'BasicPagesController@consentForm');

//Provider
Route::post('/provider/login', 'Provider\DefaultController@login');
Route::post('/provider/reset', 'Provider\DefaultController@resetPassword');
Route::get('/provider/staffs', 'Provider\DefaultController@getAllStaff');
Route::get('/provider/staffs/{id}', 'Provider\DefaultController@getUsersById');
Route::get('/provider/clinic', 'Provider\DefaultController@providerInfo');
Route::post('/provider/staff/update', 'Provider\DefaultController@update');
Route::get('/provider/description/{id}', 'Provider\DefaultController@getDescription');
Route::post('/provider/description/update/{id}', 'Provider\DefaultController@updateDescription');
Route::get('/provider/get/clinicHours/{id}', 'Provider\DefaultController@getClinicHours');
Route::get('/provider', 'Provider\DefaultController@getAllProviders');

//Family Planning Type
Route::get('/patient/fpm', 'Patient\DefaultController@getFpm');
