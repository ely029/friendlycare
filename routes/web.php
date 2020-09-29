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

Route::get('/', 'HomeController@index');
