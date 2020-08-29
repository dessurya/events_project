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

Route::name('site.')->group(function(){
    Route::get('/', 'Site\HomeController@index')->name('home.index');

    Route::name('event.')->prefix('event/')->group(function(){
        Route::get('/', 'Site\EventController@index')->name('index');
        Route::get('/ongoing', 'Site\EventController@ongoing')->name('ongoing');
        Route::post('/ongoing/load', 'Site\EventController@ongoingLoad')->name('ongoingLoad');
        Route::get('/upcomming', 'Site\EventController@upcomming')->name('upcomming');
        Route::post('/upcomming/load', 'Site\EventController@upcommingLoad')->name('upcommingLoad');
        Route::get('/past', 'Site\EventController@past')->name('past');
        Route::post('/past/load', 'Site\EventController@pastLoad')->name('pastLoad');
        Route::get('/find', 'Site\EventController@search')->name('search');
        Route::post('/find', 'Site\EventController@searchLoad')->name('searchLoad');
        Route::get('/{type}/{encode}', 'Site\EventController@show')->name('show');
        Route::post('/registration', 'Site\EventController@registration')->name('registration');
    });
    Route::get('/contact-us', 'Site\HomeController@contact')->name('contact.index');
});

Route::name('panel.')->prefix('panel/')->group(function(){
    Route::get('/', 'Panel\AuthController@redirectLogin');
    Route::get('login', 'Panel\AuthController@login')->name('login');
    Route::post('sign-in', 'Panel\AuthController@signin')->name('signin');

    Route::middleware('users')->group(function() {
        Route::get('/dashboard', 'Panel\DashboardController@index')->name('dashboard');

        Route::get('/self-data', 'Panel\UserController@profile')->name('self-data');
        Route::post('/self-data', 'Panel\UserController@profileStore')->name('self-data-store');
        Route::post('/new-register/event/check', 'Panel\NotificationController@newRegister')->name('newRegisterEventCheck');


        Route::name('user.')->prefix('user/')->group(function(){
            Route::get('/list', 'Panel\UserController@list')->name('list');
            Route::post('/store', 'Panel\UserController@store')->name('store');
            Route::post('/list', 'Panel\UserController@getData')->name('getData');
            Route::post('/reset-password', 'Panel\UserController@resetPassword')->name('reset.password');
            Route::post('/form', 'Panel\UserController@form')->name('form');
            Route::post('/delete', 'Panel\UserController@delete')->name('delete');
            
            Route::get('/logs', 'Panel\UserHistoryController@logs')->name('logs');
            Route::post('/logs-data', 'Panel\UserHistoryController@logsData')->name('logsData');

        });

        Route::name('master.')->prefix('master-data/')->group(function(){
            Route::name('website.')->prefix('website/')->group(function(){
                Route::get('/list', 'Panel\MasterWebsiteController@list')->name('list');
                Route::post('/list', 'Panel\MasterWebsiteController@getData')->name('getData');
                Route::post('/form', 'Panel\MasterWebsiteController@form')->name('form');
                Route::post('/store', 'Panel\MasterWebsiteController@store')->name('store');
                Route::post('/delete', 'Panel\MasterWebsiteController@delete')->name('delete');
            });

            Route::name('bank.')->prefix('bank/')->group(function(){
                Route::get('/list', 'Panel\MasterBankController@list')->name('list');
                Route::post('/list', 'Panel\MasterBankController@getData')->name('getData');
                Route::post('/form', 'Panel\MasterBankController@form')->name('form');
                Route::post('/store', 'Panel\MasterBankController@store')->name('store');
                Route::post('/delete', 'Panel\MasterBankController@delete')->name('delete');
            });

            Route::name('participants.')->prefix('participants/')->group(function(){
                Route::get('/list', 'Panel\ParticipantsController@list')->name('list');
                Route::post('/list', 'Panel\ParticipantsController@getData')->name('getData');
                Route::post('/show', 'Panel\ParticipantsController@show')->name('show');

                Route::post('/tourne', 'Panel\ParticipantsController@tourne')->name('tourne');
                Route::post('/coupon', 'Panel\ParticipantsController@coupon')->name('coupon');
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
                Route::post('/generatestatus', 'Panel\EventTournamentController@generatestatus')->name('generatestatus');
                Route::post('/addparticipants', 'Panel\EventTournamentController@addparticipants')->name('addparticipants');
            });
            Route::name('coupon.')->prefix('coupon/')->group(function(){
                Route::get('/list', 'Panel\EventCouponController@list')->name('list');
                Route::post('/list', 'Panel\EventCouponController@getData')->name('getData');
                Route::post('/form', 'Panel\EventCouponController@form')->name('form');
                Route::post('/store', 'Panel\EventCouponController@store')->name('store');
                Route::post('/delete', 'Panel\EventCouponController@delete')->name('delete');
                Route::post('/gift', 'Panel\EventCouponController@gift')->name('gift');
                Route::post('/gifted', 'Panel\EventCouponController@gifted')->name('gifted');
                Route::post('/generatestatus', 'Panel\EventCouponController@generatestatus')->name('generatestatus');
                Route::post('/addparticipants', 'Panel\EventCouponController@addparticipants')->name('addparticipants');
            });
            Route::name('other.')->prefix('other/')->group(function(){
                Route::get('/list', 'Panel\EventOtherController@list')->name('list');
                Route::post('/list', 'Panel\EventOtherController@getData')->name('getData');
                Route::post('/form', 'Panel\EventOtherController@form')->name('form');
                Route::post('/store', 'Panel\EventOtherController@store')->name('store');
                Route::post('/delete', 'Panel\EventOtherController@delete')->name('delete');
                Route::post('/generatestatus', 'Panel\EventOtherController@generatestatus')->name('generatestatus');
            });
            Route::name('history.')->prefix('history/')->group(function(){
                Route::get('/list', 'Panel\EventHistoryController@list')->name('list');
                Route::post('/list', 'Panel\EventHistoryController@getData')->name('getData');
            });
        });

        Route::name('register.')->prefix('register/')->group(function(){
            Route::name('tournament.')->prefix('tournament/')->group(function(){
                Route::name('list.')->prefix('list/')->group(function(){
                    Route::get('/new', 'Panel\RegisterTournamentController@newList')->name('new');
                    Route::get('/reject', 'Panel\RegisterTournamentController@rejectList')->name('reject');
                    Route::get('/history', 'Panel\RegisterTournamentController@historyList')->name('history');
                });
                Route::name('getData.')->prefix('getData/')->group(function(){
                    Route::post('/new', 'Panel\RegisterTournamentController@newGetData')->name('new');
                    Route::post('/reject', 'Panel\RegisterTournamentController@rejectGetData')->name('reject');
                    Route::post('/history', 'Panel\RegisterTournamentController@getData')->name('history');
                });
                Route::post('/store/{id}', 'Panel\RegisterTournamentController@store')->name('store');
                Route::post('/confirm', 'Panel\RegisterTournamentController@confirm')->name('confirm');
                Route::post('/reject', 'Panel\RegisterTournamentController@reject')->name('reject');
            });
            Route::name('coupon.')->prefix('coupon/')->group(function(){
                Route::name('list.')->prefix('list/')->group(function(){
                    Route::get('/new', 'Panel\RegisterCouponController@newList')->name('new');
                    Route::get('/reject', 'Panel\RegisterCouponController@rejectList')->name('reject');
                    Route::get('/history', 'Panel\RegisterCouponController@historyList')->name('history');
                });
                Route::name('getData.')->prefix('getData/')->group(function(){
                    Route::post('/new', 'Panel\RegisterCouponController@newGetData')->name('new');
                    Route::post('/reject', 'Panel\RegisterCouponController@rejectGetData')->name('reject');
                    Route::post('/history', 'Panel\RegisterCouponController@getData')->name('history');
                });
                // Route::get('/list', 'Panel\RegisterCouponController@list')->name('list');
                // Route::post('/list', 'Panel\RegisterCouponController@getData')->name('getData');
                Route::post('/gift', 'Panel\RegisterCouponController@gift')->name('gift');
                Route::post('/reject', 'Panel\RegisterCouponController@reject')->name('reject');
            });
        });

        Route::name('coupon.')->prefix('coupon/')->group(function(){
            Route::get('/list', 'Panel\CouponController@list')->name('list');
            Route::post('/list', 'Panel\CouponController@getData')->name('getData');
            Route::post('/used', 'Panel\CouponController@used')->name('used');
            Route::post('/rejected', 'Panel\CouponController@rejected')->name('rejected');
            Route::post('/banned', 'Panel\CouponController@banned')->name('banned');
        });

        Route::get('/sign-out', 'Panel\AuthController@logout')->name('signout');
    });
});
