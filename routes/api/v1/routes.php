<?php

Route::post('/register','Api\V1\Auth\RegisterController@store');
Route::post('/login','Api\V1\Auth\LoginController@login');

Route::get('/fetch-shows','Api\V1\Show\ShowController@fetchShows');
Route::get('movie-detail/{movieId}','Api\V1\Movie\MovieController@movieDetail');
Route::get('movie-detail/{movieId}/fetch-shows','Api\V1\Movie\MovieController@fetchShows');


Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/auth/check', 'Api\V1\Auth\LoginController@check');
    Route::post('/logout','Api\V1\Auth\LogoutController@logout');

    Route::post('/book-ticket','Api\V1\Booking\BookingController@doBooking');
    Route::get('/show-my-bookings','Api\V1\Booking\BookingController@showMyBookings');



    Route::group(['prefix' => '/admin'],function(){
        Route::resource('manage-theatre','Api\V1\Theatre\ManageTheatreController');
        Route::resource('manage-movie','Api\V1\Movie\ManageMovieController');
        Route::resource('manage-show','Api\V1\Show\ManageShowController');
        Route::resource('manage-slot','Api\V1\Slot\ManageSlotController');
    });
});