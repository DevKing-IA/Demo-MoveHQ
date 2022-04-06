<?php

use Illuminate\Support\Facades\Route;

Route::namespace('MovehqApp\Http\Controllers\Api')
    ->prefix('api')
    ->middleware('api')
    ->group(function () {
        Route::post('auth/login', 'Auth\LoginController@login');
        Route::post('auth/ping', 'Auth\PingController@ping');

        Route::middleware('auth:api')->group(function () {
            Route::post('auth/logout', 'Auth\LoginController@logout');
        });
    });
