<?php

use \Illuminate\Support\Facades\Route;

// Admin API - auth required
Route::group([
    'prefix' => 'admin-api',
    'middleware' => 'admin',
    'namespace' => 'MovehqApp\Http\Controllers\AdminApi',
], function () {

    // Product routes
    Route::get('product', 'ProductController@index');
    Route::post('product/create-random', 'ProductController@createRandom');
    Route::post('product/remove', 'ProductController@remove');
});
