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

Route::name('panel.')->prefix('panel/')->group(function(){
    Route::get('/', 'Panel\AuthController@redirectLogin');
    Route::get('login', 'Panel\AuthController@login')->name('login');
    Route::post('sign-in', 'Panel\AuthController@signin')->name('signin');

    Route::middleware('users')->group(function() {
        Route::get('/dashboard', 'Panel\DashboardController@index')->name('dashboard');

        Route::get('/self-data', 'Panel\UserController@index')->name('self-data');
        Route::post('/new-register/event/check', 'Panel\NotificationController@newRegister')->name('newRegisterEventCheck');


        Route::name('user.')->prefix('user/')->group(function(){
            Route::get('/list', 'Panel\UserController@list')->name('list');
            Route::get('/logs', 'Panel\UserController@index')->name('logs');
            Route::post('/store', 'Panel\UserController@store')->name('store');
            
            Route::post('/list', 'Panel\UserController@getData')->name('getData');
            Route::post('/reset-password', 'Panel\UserController@resetPassword')->name('reset.password');
            Route::post('/form', 'Panel\UserController@form')->name('form');
            Route::post('/delete', 'Panel\UserController@delete')->name('delete');
        });

        Route::name('master.')->prefix('master-data/')->group(function(){
            Route::name('website.')->prefix('website/')->group(function(){
                Route::get('/list', 'Panel\MasterWebsiteController@list')->name('list');
                Route::post('/list', 'Panel\MasterWebsiteController@getData')->name('getData');
                Route::post('/form', 'Panel\MasterWebsiteController@form')->name('form');
                Route::post('/store', 'Panel\MasterWebsiteController@store')->name('store');
                Route::post('/delete', 'Panel\MasterWebsiteController@delete')->name('delete');
            });

            Route::name('participants.')->prefix('participants/')->group(function(){
                Route::get('/list', 'Panel\ParticipantsController@list')->name('list');
                Route::post('/list', 'Panel\ParticipantsController@getData')->name('getData');
                Route::post('/show', 'Panel\ParticipantsController@show')->name('show');
            });
        });

        Route::name('interface.')->prefix('interface/')->group(function(){
            Route::get('/list', 'Panel\InterFaceController@list')->name('list');
            Route::post('/list', 'Panel\InterFaceController@getData')->name('getData');
            Route::post('/form', 'Panel\InterFaceController@form')->name('form');
            Route::post('/store', 'Panel\InterFaceController@store')->name('store');

            Route::name('runningtext.')->prefix('running-text/')->group(function(){
                Route::get('/list', 'Panel\RunningTextController@list')->name('list');
                Route::post('/list', 'Panel\RunningTextController@getData')->name('getData');
                Route::post('/form', 'Panel\RunningTextController@form')->name('form');
                Route::post('/store', 'Panel\RunningTextController@store')->name('store');
                Route::post('/delete', 'Panel\RunningTextController@delete')->name('delete');
            });

            Route::name('mainslider.')->prefix('main-slider/')->group(function(){
                Route::get('/list', 'Panel\MainSliderController@list')->name('list');
                Route::post('/list', 'Panel\MainSliderController@getData')->name('getData');
                Route::post('/form', 'Panel\MainSliderController@form')->name('form');
                Route::post('/store', 'Panel\MainSliderController@store')->name('store');
                Route::post('/delete', 'Panel\MainSliderController@delete')->name('delete');
            });
        });

        Route::name('event.')->prefix('event/')->group(function(){
            Route::name('tournament.')->prefix('tournament/')->group(function(){
                Route::get('/list', 'Panel\EventTournamentController@list')->name('list');
                Route::post('/list', 'Panel\EventTournamentController@getData')->name('getData');
                Route::post('/form', 'Panel\EventTournamentController@form')->name('form');
                Route::post('/store', 'Panel\EventTournamentController@store')->name('store');
                Route::post('/delete', 'Panel\EventTournamentController@delete')->name('delete');
                Route::post('/leaderboard', 'Panel\EventTournamentController@leaderboard')->name('leaderboard');
                Route::post('/leaderboard/add-point', 'Panel\EventTournamentController@leaderboardAddPoint')->name('leaderboardAddPoint');
                Route::post('/leaderboard/generate-rank', 'Panel\EventTournamentController@leaderboardGenerateRank')->name('leaderboardGenerateRank');
            });
            Route::name('coupon.')->prefix('coupon/')->group(function(){
                Route::get('/list', 'Panel\EventCouponController@list')->name('list');
                Route::post('/list', 'Panel\EventCouponController@getData')->name('getData');
                Route::post('/form', 'Panel\EventCouponController@form')->name('form');
                Route::post('/store', 'Panel\EventCouponController@store')->name('store');
                Route::post('/delete', 'Panel\EventCouponController@delete')->name('delete');
                Route::post('/gift', 'Panel\EventCouponController@gift')->name('gift');
            });
            Route::name('other.')->prefix('other/')->group(function(){
                Route::get('/list', 'Panel\EventOtherController@list')->name('list');
                Route::post('/list', 'Panel\EventOtherController@getData')->name('getData');
                Route::post('/form', 'Panel\EventOtherController@form')->name('form');
                Route::post('/store', 'Panel\EventOtherController@store')->name('store');
                Route::post('/delete', 'Panel\EventOtherController@delete')->name('delete');
            });
        });

        Route::name('register.')->prefix('register/')->group(function(){
            Route::name('tournament.')->prefix('tournament/')->group(function(){
                Route::get('/list', 'Panel\RegisterTournamentController@list')->name('list');
                Route::post('/list', 'Panel\RegisterTournamentController@getData')->name('getData');
                Route::post('/confirm', 'Panel\RegisterTournamentController@confirm')->name('confirm');
                Route::post('/reject', 'Panel\RegisterTournamentController@reject')->name('reject');
            });
            Route::name('coupon.')->prefix('coupon/')->group(function(){
                Route::get('/list', 'Panel\RegisterCouponController@list')->name('list');
                Route::post('/list', 'Panel\RegisterCouponController@getData')->name('getData');
                Route::post('/gift', 'Panel\RegisterCouponController@gift')->name('gift');
                Route::post('/reject', 'Panel\RegisterCouponController@reject')->name('reject');
            });
        });

        Route::get('/sign-out', 'Panel\AuthController@logout')->name('signout');
    });
});
