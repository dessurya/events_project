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

Route::get('/generate', 'GenerateNumberController@index');
Route::post('/generate/cache', 'GenerateNumberController@cache')->name('generate.cache');

Route::name('site.')->prefix('default/')->group(function(){
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

    Route::post('/get/coupon', 'Site\EventController@getCoupon')->name('get.coupon');
});

Route::name('azn.')->group(function(){
    Route::get('/', 'Azn\HomeController@index')->name('home.index');

    Route::name('event.')->prefix('event/')->group(function(){
        Route::get('/', 'Azn\EventController@index')->name('index');
        Route::get('/ongoing', 'Azn\EventController@ongoing')->name('ongoing');
        Route::post('/ongoing/load', 'Azn\EventController@ongoingLoad')->name('ongoingLoad');

        Route::get('/upcomming', 'Azn\EventController@upcomming')->name('upcomming');
        Route::post('/upcomming/load', 'Azn\EventController@upcommingLoad')->name('upcommingLoad');

        Route::get('/past', 'Azn\EventController@past')->name('past');
        Route::post('/past/load', 'Azn\EventController@pastLoad')->name('pastLoad');

        Route::get('/find', 'Azn\EventController@search')->name('search');
        Route::post('/find', 'Azn\EventController@searchLoad')->name('searchLoad');

        Route::get('/{type}/{encode}', 'Azn\EventController@show')->name('show');
        Route::post('/registration', 'Azn\EventController@registration')->name('registration');
    });
    Route::get('/contact-us', 'Azn\HomeController@contact')->name('contact.index');

    Route::post('/get/coupon', 'Azn\EventController@getCoupon')->name('get.coupon');
});