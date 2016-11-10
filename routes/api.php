<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {
    /*
    |--------------------------------------------------------------------------
    | Exclusive routes for Version 1
    |--------------------------------------------------------------------------
    */
    Route::group(['namespace' => 'V1', 'prefix' => 'v1'], function () {
        /*
        |--------------------------------------------------------------------------
        | Exclusive routes for authentication service
        |--------------------------------------------------------------------------
        */
        Route::group(['namespace' => 'Authentication'], function () {
            Route::post('/authentication', 'AuthenticationController@authenticate');
            Route::post('/authentication/forgot_password', 'AuthenticationController@forgotPassword');

            /*
            |--------------------------------------------------------------------------
            | Routes with required login
            |--------------------------------------------------------------------------
            */
            Route::group(['middleware' => ['jwt.auth']], function () {

                Route::put('/authentication/change_password', 'AuthenticationController@changePassword');
                Route::post('/authentication/logout', 'AuthenticationController@logout');

                Route::get('/authentication/refresh_token', 'AuthenticationController@refreshToken');
            });
        });

        /*
        |--------------------------------------------------------------------------
        | Routes with required login
        |--------------------------------------------------------------------------
        */
        Route::group(['middleware' => ['jwt.auth']], function () {
            /*
            |--------------------------------------------------------------------------
            | Routes for wishlists service
            |--------------------------------------------------------------------------
            */
            Route::delete('/wishlists/{id}', 'WishlistsController@destroy');
            Route::put('/wishlists/{id}', 'WishlistsController@update');
            Route::get('/wishlists/{id}', 'WishlistsController@show');
            Route::post('/wishlists', 'WishlistsController@store');
            Route::get('/wishlists', 'WishlistsController@index');
        });
    });
        
});
