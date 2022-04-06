<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->namespace('MovehqApp\Http\Controllers')
    ->group(function () {
        // Login route
        Route::any('/auth/login', 'HomeController@home')->name('login');
    });
