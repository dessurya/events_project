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

Route::get('/', 'AuthController@redirectLogin');
Route::get('login', 'AuthController@login')->name('login');
Route::post('sign-in', 'AuthController@signin')->name('signin');

Route::middleware('users')->group(function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/self-data', 'UserController@profile')->name('self-data');
    Route::post('/self-data', 'UserController@profileStore')->name('self-data-store');
    Route::post('/new-register/event/check', 'NotificationController@newRegister')->name('newRegisterEventCheck');


    Route::name('user.')->prefix('user/')->group(function(){
        Route::get('/list', 'UserController@list')->name('list');
        Route::post('/store', 'UserController@store')->name('store');
        Route::post('/list', 'UserController@getData')->name('getData');
        Route::post('/reset-password', 'UserController@resetPassword')->name('reset.password');
        Route::post('/form', 'UserController@form')->name('form');
        Route::post('/delete', 'UserController@delete')->name('delete');
        
        Route::get('/logs', 'UserHistoryController@logs')->name('logs');
        Route::post('/logs-data', 'UserHistoryController@logsData')->name('logsData');

    });

    Route::name('master.')->prefix('master-data/')->group(function(){
        Route::name('website.')->prefix('website/')->group(function(){
            Route::get('/list', 'MasterWebsiteController@list')->name('list');
            Route::post('/list', 'MasterWebsiteController@getData')->name('getData');
            Route::post('/form', 'MasterWebsiteController@form')->name('form');
            Route::post('/store', 'MasterWebsiteController@store')->name('store');
            Route::post('/delete', 'MasterWebsiteController@delete')->name('delete');
        });

        Route::name('bank.')->prefix('bank/')->group(function(){
            Route::get('/list', 'MasterBankController@list')->name('list');
            Route::post('/list', 'MasterBankController@getData')->name('getData');
            Route::post('/form', 'MasterBankController@form')->name('form');
            Route::post('/store', 'MasterBankController@store')->name('store');
            Route::post('/delete', 'MasterBankController@delete')->name('delete');
        });

        Route::name('participants.')->prefix('participants/')->group(function(){
            Route::get('/list', 'ParticipantsController@list')->name('list');
            Route::post('/list', 'ParticipantsController@getData')->name('getData');
            Route::post('/add', 'ParticipantsController@add')->name('add');
            Route::post('/show', 'ParticipantsController@show')->name('show');
            Route::post('/store', 'ParticipantsController@store')->name('store');

            Route::post('/tourne', 'ParticipantsController@tourne')->name('tourne');
            Route::post('/coupon', 'ParticipantsController@coupon')->name('coupon');
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
            Route::post('/list', 'EventTournamentController@getData')->name('getData');
            Route::post('/form', 'EventTournamentController@form')->name('form');
            Route::post('/store', 'EventTournamentController@store')->name('store');
            Route::post('/delete', 'EventTournamentController@delete')->name('delete');
            Route::post('/leaderboard', 'EventTournamentController@leaderboard')->name('leaderboard');
            Route::post('/leaderboard/add-point', 'EventTournamentController@leaderboardAddPoint')->name('leaderboardAddPoint');
            Route::post('/leaderboard/generate-rank', 'EventTournamentController@leaderboardGenerateRank')->name('leaderboardGenerateRank');
            Route::post('/generatestatus', 'EventTournamentController@generatestatus')->name('generatestatus');
            Route::post('/fullRestrictedParticipantsUsername', 'EventTournamentController@fullRestrictedParticipantsUsername')->name('fullRestrictedParticipantsUsername');
            Route::post('/addparticipants', 'EventTournamentController@addparticipants')->name('addparticipants');
        });
        Route::name('coupon.')->prefix('coupon/')->group(function(){
            Route::get('/list', 'EventCouponController@list')->name('list');
            Route::post('/list', 'EventCouponController@getData')->name('getData');
            Route::post('/form', 'EventCouponController@form')->name('form');
            Route::post('/store', 'EventCouponController@store')->name('store');
            Route::post('/delete', 'EventCouponController@delete')->name('delete');
            Route::post('/gift', 'EventCouponController@gift')->name('gift');
            Route::post('/gifted', 'EventCouponController@gifted')->name('gifted');
            Route::post('/generatestatus', 'EventCouponController@generatestatus')->name('generatestatus');
            Route::post('/addparticipants', 'EventCouponController@addparticipants')->name('addparticipants');
        });
        Route::name('other.')->prefix('other/')->group(function(){
            Route::get('/list', 'EventOtherController@list')->name('list');
            Route::post('/list', 'EventOtherController@getData')->name('getData');
            Route::post('/form', 'EventOtherController@form')->name('form');
            Route::post('/store', 'EventOtherController@store')->name('store');
            Route::post('/delete', 'EventOtherController@delete')->name('delete');
            Route::post('/generatestatus', 'EventOtherController@generatestatus')->name('generatestatus');
        });
        Route::name('history.')->prefix('history/')->group(function(){
            Route::get('/list', 'EventHistoryController@list')->name('list');
            Route::post('/list', 'EventHistoryController@getData')->name('getData');
        });
    });

    Route::name('register.')->prefix('register/')->group(function(){
        Route::name('tournament.')->prefix('tournament/')->group(function(){
            Route::name('list.')->prefix('list/')->group(function(){
                Route::get('/new', 'RegisterTournamentController@newList')->name('new');
                Route::get('/reject', 'RegisterTournamentController@rejectList')->name('reject');
                Route::get('/history', 'RegisterTournamentController@historyList')->name('history');
            });
            Route::name('getData.')->prefix('getData/')->group(function(){
                Route::post('/new', 'RegisterTournamentController@newGetData')->name('new');
                Route::post('/reject', 'RegisterTournamentController@rejectGetData')->name('reject');
                Route::post('/history', 'RegisterTournamentController@getData')->name('history');
            });
            Route::post('/store/{id}', 'RegisterTournamentController@store')->name('store');
            Route::post('/confirm', 'RegisterTournamentController@confirm')->name('confirm');
            Route::post('/reject', 'RegisterTournamentController@reject')->name('reject');
        });
        Route::name('coupon.')->prefix('coupon/')->group(function(){
            Route::name('list.')->prefix('list/')->group(function(){
                Route::get('/new', 'RegisterCouponController@newList')->name('new');
                Route::get('/reject', 'RegisterCouponController@rejectList')->name('reject');
                Route::get('/history', 'RegisterCouponController@historyList')->name('history');
            });
            Route::name('getData.')->prefix('getData/')->group(function(){
                Route::post('/new', 'RegisterCouponController@newGetData')->name('new');
                Route::post('/reject', 'RegisterCouponController@rejectGetData')->name('reject');
                Route::post('/history', 'RegisterCouponController@getData')->name('history');
            });
            Route::post('/store/{id}', 'RegisterCouponController@store')->name('store');
            Route::post('/gift', 'RegisterCouponController@gift')->name('gift');
            Route::post('/reject', 'RegisterCouponController@reject')->name('reject');
        });
    });

    Route::name('coupon.')->prefix('coupon/')->group(function(){
        Route::get('/list', 'CouponController@list')->name('list');
        Route::post('/list', 'CouponController@getData')->name('getData');
        Route::post('/used', 'CouponController@used')->name('used');
        Route::post('/rejected', 'CouponController@rejected')->name('rejected');
        Route::post('/banned', 'CouponController@banned')->name('banned');
    });

    Route::get('/sign-out', 'AuthController@logout')->name('signout');
});
