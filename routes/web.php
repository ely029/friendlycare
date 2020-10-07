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
    Route::get('/', 'DashboardController@index');

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
    //edit admin profile
    Route::get('/admin/{id}', 'Admin\UserManagementController@editAdminProfilePage');
    Route::get('/admin/edit/{id}', 'Admin\UserManagementController@editAdminProfile')->name('editAdminProfile');
    Route::post('/admin/update', 'Admin\UserManagementController@updateAdmin')->name('updateAdmin');
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
    //edit profile
    Route::get('/profile', 'Admin\ProviderManagementController@editProviderProfile')->name('editProviderProfile');
});
    Route::get('/', 'HomeController@index');
    Route::get('/portal', 'Admin\AdminController@showLogin')->name('adminLogin');
    Route::post('/authenticate', 'Admin\AdminController@authenticate')->name('authenticate');
