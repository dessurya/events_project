<?php

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

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('login', 'AuthController@login')->name('login');
Route::post('sign-in', 'AuthController@signin')->name('signin');

Route::middleware('users')->group(function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/self-data', 'UserController@index')->name('self-data');

    Route::name('user.')->prefix('user/')->group(function(){
        Route::get('/list', 'UserController@list')->name('list');
        Route::get('/logs', 'UserController@index')->name('logs');
        Route::post('/store', 'UserController@store')->name('store');
        
        Route::post('/list', 'UserController@getData')->name('getData');
        Route::post('/reset-password', 'UserController@resetPassword')->name('reset.password');
        Route::post('/form', 'UserController@form')->name('form');
        Route::post('/delete', 'UserController@delete')->name('delete');
    });

    Route::name('master.')->prefix('master-data/')->group(function(){
        Route::name('website.')->prefix('website/')->group(function(){
            Route::get('/list', 'MasterWebsiteController@list')->name('list');
            Route::post('/list', 'MasterWebsiteController@getData')->name('getData');
            Route::post('/form', 'MasterWebsiteController@form')->name('form');
            Route::post('/store', 'MasterWebsiteController@store')->name('store');
            Route::post('/delete', 'MasterWebsiteController@delete')->name('delete');
        });
    });

    Route::name('interface.')->prefix('interface/')->group(function(){
        Route::get('/list', 'InterFaceController@list')->name('list');
        Route::post('/list', 'InterFaceController@getData')->name('getData');
        Route::post('/form', 'InterFaceController@form')->name('form');
        Route::post('/store', 'InterFaceController@store')->name('store');

        Route::name('runningtext.')->prefix('running-text/')->group(function(){
            Route::get('/list', 'RunningTextController@list')->name('list');
            Route::post('/list', 'RunningTextController@getData')->name('getData');
            Route::post('/form', 'RunningTextController@form')->name('form');
            Route::post('/store', 'RunningTextController@store')->name('store');
            Route::post('/delete', 'RunningTextController@delete')->name('delete');
        });

        Route::name('mainslider.')->prefix('main-slider/')->group(function(){
            Route::get('/list', 'MainSliderController@list')->name('list');
            Route::post('/list', 'MainSliderController@getData')->name('getData');
            Route::post('/form', 'MainSliderController@form')->name('form');
            Route::post('/store', 'MainSliderController@store')->name('store');
            Route::post('/delete', 'MainSliderController@delete')->name('delete');
        });
    });

    Route::name('event.')->prefix('event/')->group(function(){
        Route::name('tournament.')->prefix('tournament/')->group(function(){
            Route::get('/list', 'EventTournamentController@list')->name('list');
        });
        Route::name('coupon.')->prefix('coupon/')->group(function(){
            Route::get('/list', 'EventCouponController@list')->name('list');
        });
        Route::name('other.')->prefix('other/')->group(function(){
            Route::get('/list', 'EventOtherController@list')->name('list');
        });
    });

    Route::get('/sign-out', 'AuthController@logout')->name('signout');
});
