<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'middleware' => 'auth'], static function () {
    Route::get('/', 'DashboardController@index')->name('index');

    Route::group(['middleware' => 'route.access'], static function () {
        Route::resource('roles', 'RolesController', [
            'except' => ['show'],
        ]);

        Route::get('/users', 'UsersController@index');
        Route::get('/users/create', 'UsersController@create');
        Route::post('/users', 'UsersController@store');
        Route::get('/users/{user}/edit', 'UsersController@edit');
        Route::patch('/users/{user}', 'UsersController@update');
        Route::delete('/users/{user}', 'UsersController@destroy');
    });
});

Route::group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => 'auth'], static function () {
    Route::get('/', 'AdminController@index');
    Route::get('/accounts', 'AdminController@accounts')->name('admin.accounts');
    Route::get('/logout', 'AdminController@logout')->name('admin.logout');
    Route::post('/change-password', 'AdminController@changePassword')->name('admin.changePassword');
});

//user management
Route::group(['prefix' => 'user', 'middleware' => 'auth'], static function () {
    //index page
    Route::get('/list', 'Admin\UserManagementController@index')->name('userManagement');
    // create account
    Route::get('/create', 'Admin\UserManagementController@role')->name('userRole');
    Route::get('/create/admin/1', 'Admin\UserManagementController@adminFirstPage')->name('adminFirstPage');
    Route::get('/create/staff/1', 'Admin\UserManagementController@staffFirstPage')->name('staffFirstPage');
    Route::post('/create/admin', 'Admin\UserManagementController@createAdmin')->name('createAdmin');
    Route::post('/create/staff', 'Admin\UserManagementController@createStaff')->name('createStaff');
    //edit profile
    Route::get('/page/{id}', 'Admin\UserManagementController@editUserProfilePage')->name('editUserProfilePage');
    Route::get('/edit/{id}', 'Admin\UserManagementController@editUserProfile')->name('editUserProfile');
    Route::post('/update', 'Admin\UserManagementController@updateUser')->name('updateUser');
    Route::get('/delete/{id}', 'Admin\UserManagementController@deleteUser')->name('deleteUser');
    Route::post('/filter', 'Admin\UserManagementController@filter')->name('userManagement.filter');
    Route::get('/search', 'Admin\UserManagementController@search')->name('userManagement.search');
    Route::get('reset-password/{id}', 'Admin\UserManagementController@emailResetPassword')->name('userManagement.emailResetpassword');
});

//provider management
//lookup location
Route::get('/province', 'Admin\ProviderManagementController@province')->name('provider.province');
Route::get('/city', 'Admin\ProviderManagementController@city')->name('provider.city');
Route::get('/barangay', 'Admin\ProviderManagementController@barangay')->name('provider.barangay');

Route::group(['prefix' => 'provider', 'middleware' => 'auth'], static function () {
    //index page
    Route::get('/list', 'Admin\ProviderManagementController@index')->name('providerManagement');
    //create provider
    Route::get('/create/1', 'Admin\ProviderManagementController@createFirstPage')->name('providerCreateFirstPage');
    Route::get('/create/2', 'Admin\ProviderManagementController@createSecondPage')->name('providerCreateSecondPage');
    Route::get('/create/3', 'Admin\ProviderManagementController@createThirdPage')->name('providerCreateThirdPage');
    Route::post('/store/firstpage', 'Admin\ProviderManagementController@storeFirstPage')->name('storeFirstPage');
    Route::post('/store/secondpage', 'Admin\ProviderManagementController@storeSecondPage')->name('storeSecondPage');
    Route::post('/store/thirdpage', 'Admin\ProviderManagementController@storeThirdPage')->name('storeThirdPage');

    //profile p[icture upload
    Route::post('/profile-upload', 'Admin\ProviderManagementController@profPicUpload')->name('provider.profPicUpload');
    //provider information page
    Route::get('/profile/{id}', 'Admin\ProviderManagementController@editProviderInformation')->name('editProviderProfile');
    Route::get('/edit/{id}', 'Admin\ProviderManagementController@editPage')->name('editPage');
    Route::post('/uploadpic', 'Admin\ProviderManagementController@uploadProfilePic')->name('provider.profilePic');
    Route::post('/update', 'Admin\ProviderManagementController@updateProvider')->name('updateProvider');
    Route::post('/galleryUpload', 'Admin\ProviderManagementController@galleryUpload')->name('provider.galleryUpload');
    Route::get('/delete/{id}', 'Admin\ProviderManagementController@deleteProvider')->name('deleteProvider');
    Route::get('/ratings/{id}', 'Admin\ProviderManagementController@ratingPerPatient')->name('provider.reviews');
    Route::get('/enableaccount', 'Admin\ProviderManagementController@enableProvider')->name('provider.enableProvider');
    Route::get('/disableaccount', 'Admin\ProviderManagementController@disableProvider')->name('provider.disableProvider');
    Route::get('/deletegallery/{id}/{clinicId}', 'Admin\ProviderManagementController@deleteGallery')->name('provider.deleteGallery');
});

//basic pages
Route::group(['prefix' => 'basicpages', 'middleware' => 'auth'], static function () {
    //index page
    Route::get('/list', 'Admin\BasicPagesController@index')->name('basicPages');
    Route::get('/{id}', 'Admin\BasicPagesController@informationPage')->name('basicPages.informationPage');
    Route::get('/edit/{id}', 'Admin\BasicPagesController@editPage')->name('basicPages.editPage');
    Route::post('/update', 'Admin\BasicPagesController@storeEdit')->name('basicPages.storeEdit');
    Route::get('/delete/{id}', 'Admin\BasicPagesController@deleteBasicSection')->name('basicPages.deleteBasicSection');
});

Route::group(['prefix' => 'reset'], static function () {
    //reset page
    Route::get('/{id}', 'Admin\ResetController@index')->name('resetPassword.index');
    Route::post('/password', 'Admin\ResetController@updatePassword')->name('resetPassword.updatePassword');
});

Route::group(['prefix' => 'password'], static function () {
    //set password
    Route::get('/{id}', 'Admin\PasswordController@index')->name('password.index');
    Route::post('/setup', 'Admin\PasswordController@readyPassword')->name('password.readyPassword');
});

Route::group(['prefix' => 'fpm'], static function () {
    //create
    Route::get('/', 'Admin\FamilyPlanningMethodController@index')->name('familyPlanningMethod.index');
    Route::get('/create/1', 'Admin\FamilyPlanningMethodController@firstPage')->name('familyPlanningMethod.firstPage');
    Route::get('/create/2', 'Admin\FamilyPlanningMethodController@secondPage')->name('familyPlanningMethod.secondPage');
    Route::get('/create/3', 'Admin\FamilyPlanningMethodController@thirdPage')->name('familyPlanningMethod.thirdPage');
    Route::post('/create/1', 'Admin\FamilyPlanningMethodController@createOne')->name('familyPlanningMethod.createOne');
    Route::post('/create/2', 'Admin\FamilyPlanningMethodController@createTwo')->name('familyPlanningMethod.createTwo');
    Route::post('/create/3', 'Admin\FamilyPlanningMethodController@createThree')->name('familyPlanningMethod.createThree');
    Route::get('/delete/{id}', 'Admin\FamilyPlanningMethodController@delete')->name('familyPlanningMethod.delete');
    Route::get('/information/{id}', 'Admin\FamilyPlanningMethodController@information')->name('familyPlanningMethod.information');
    Route::get('/edit/{id}', 'Admin\FamilyPlanningMethodController@edit')->name('familyPlanningMethod.edit');
    Route::post('update/', 'Admin\FamilyPlanningMethodController@update')->name('familyPlanningMethod.update');
    Route::post('/icon-upload', 'Admin\FamilyPlanningMethodController@iconUpload')->name('familyPlanningMethod.iconUpload');
    Route::post('/gallery/upload', 'Admin\FamilyPlanningMethodController@galleryUpload')->name('familyPlanningMethod.galleryUpload');
    Route::post('/update/gallery/upload', 'Admin\FamilyPlanningMethodController@updateGalleryUpload')->name('familyPlanningMethod.updateGalleryUpload');
    Route::get('/gallery/delete/{id}/{serviceId}', 'Admin\FamilyPlanningMethodController@deleteServiceGallery')->name('familyPlanningMethod.deleteGallery');
});

///events and notifications
Route::group(['prefix' => 'notification'], static function () {
    Route::get('/list', 'Admin\NotificationsController@index')->name('notifications.index');
    Route::get('/create', 'Admin\NotificationsController@create')->name('notifications.create');
    Route::post('/create', 'Admin\NotificationsController@postNotification')->name('notifications.postNotification');
    Route::get('/information/{id}', 'Admin\NotificationsController@information')->name('notifications.information');
    Route::get('/edit/{id}', 'Admin\NotificationsController@edit')->name('notifications.edit');
    Route::post('/edit', 'Admin\NotificationsController@postEdit')->name('notifications.postEdit');
    Route::post('/edit/delete/{id}', 'Admin\NotificationsController@delete')->name('notifications.delete');
});

Route::group(['prefix' => 'survey'], static function () {
    Route::get('/list', 'Admin\SurveyController@index')->name('survey.index');
    Route::get('/create', 'Admin\SurveyController@create')->name('survey.create');
    Route::post('/create', 'Admin\SurveyController@post')->name('survey.post');
    Route::get('/information/{id}', 'Admin\SurveyController@information')->name('survey.information');
    Route::get('/edit/{id}', 'Admin\SurveyController@edit')->name('survey.edit');
    Route::post('/edit', 'Admin\SurveyController@postEdit')->name('survey.postEdit');
    Route::post('/delete/{id}', 'Admin\SurveyController@delete')->name('survey.delete');
});

Route::group(['prefix' => 'chatbot'], static function () {
    Route::get('/list', 'Admin\ChatbotController@index')->name('chatbot.index');
    Route::get('/create', 'Admin\ChatbotController@create')->name('chatbot.create');
    Route::post('/create', 'Admin\ChatbotController@post')->name('chatbot.post');
    Route::get('/edit/{id}', 'Admin\ChatbotController@edit')->name('chatbot.edit');
    Route::post('/edit', 'Admin\ChatbotController@update')->name('chatbot.update');
    Route::get('/delete/{id}', 'Admin\ChatbotController@delete')->name('chatbot.delete');
    Route::get('/delete/fieldset/{id}', 'Admin\ChatbotController@deleteFieldSet')->name('chatbot.deleteFieldSet');
});

Route::group(['prefix' => 'patient'], static function () {
    Route::get('/list', 'Admin\PatientManagementController@index')->name('patientManagement.index');
    Route::get('/information/{id}', 'Admin\PatientManagementController@information')->name('patientManagement.information');
    Route::get('/delete/{id}', 'Admin\PatientManagementController@delete')->name('patientManagement.delete');
    Route::get('/export', 'Admin\PatientManagementController@export')->name('patientManagement.export');
    Route::post('/filter', 'Admin\PatientManagementController@filter')->name('patientManagement.filter');
});
Route::group(['prefix' => 'booking'], static function () {
    Route::get('/index', 'Admin\BookingController@indexes')->name('booking.index');
    Route::post('/result', 'Admin\BookingController@results')->name('booking.results');
    Route::get('/export', 'Admin\BookingController@export')->name('booking.export');
});

Route::group(['prefix' => 'ads'], static function () {
    Route::get('/', 'Admin\AdsManagementController@index')->name('ads.index');
    Route::get('/create', 'Admin\AdsManagementController@create')->name('ads.create');
    Route::post('/upload-image', 'Admin\AdsManagementController@uploadImage')->name('ads.uploadImage');
    Route::post('/create', 'Admin\AdsManagementController@post')->name('ads.post');
    Route::post('/filter', 'Admin\AdsManagementController@filter')->name('ads.filter');
    Route::get('/information/{id}', 'Admin\AdsManagementController@viewInformation')->name('ads.viewInformation');
    Route::get('/delete/{id}', 'Admin\AdsManagementController@delete')->name('ads.delete');
    Route::get('/export', 'Admin\AdsManagementController@export')->name('ads.export');
});
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('/authenticate', 'Admin\AdminController@authenticate')->name('authenticate');
    Route::post('/updateclinicgallery/{id}', 'Admin\ProviderManagementController@updateClinicGallery');
    Route::get('/privacy-policy', 'Admin\AdminController@policy')->name('admin.privacy-policy');
