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

Auth::routes(['login' => false,'register' => false]);

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
});

//provider management
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
    //provider information page
    Route::get('/profile/{id}', 'Admin\ProviderManagementController@editProviderInformation')->name('editProviderProfile');
    Route::get('/edit/{id}', 'Admin\ProviderManagementController@editPage')->name('editPage');
    Route::post('/update', 'Admin\ProviderManagementController@updateProvider')->name('updateProvider');
    Route::get('/delete/{id}', 'Admin\ProviderManagementController@deleteProvider')->name('deleteProvider');
});

//basic pages
Route::group(['prefix' => 'basicpages', 'middleware' => 'auth'], static function () {
    //index page
    Route::get('/list', 'Admin\BasicPagesController@index')->name('basicPages');
    Route::get('/{id}', 'Admin\BasicPagesController@informationPage')->name('basicPages.informationPage');
    Route::get('/edit/{id}', 'Admin\BasicPagesController@editPage')->name('basicPages.editPage');
    Route::post('/update', 'Admin\BasicPagesController@storeEdit')->name('basicPages.storeEdit');
});

Route::group(['prefix' => 'reset'], static function () {
    //reset page
    Route::get('/{id}', 'Admin\ResetController@index')->name('resetPassword.index');
    Route::post('/password', 'Admin\ResetController@updatePassword')->name('resetPassword.updatePassword');
});

    Route::get('/', 'HomeController@index');
    Route::get('/portal', 'Admin\AdminController@showLogin')->name('adminLogin');
    Route::post('/authenticate', 'Admin\AdminController@authenticate')->name('authenticate');
