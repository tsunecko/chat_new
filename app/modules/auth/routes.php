<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'api',
    'module'=>'auth',
    'namespace' => 'App\modules\auth\Controllers',
    //'middleware' => 'auth:api'
], function() {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::post('login', 'AuthController@login')
        ->middleware('guest')
    ;

    Route::post('register', 'AuthController@register');

    Route::post('reset', 'AuthController@reset')
        ->middleware('CheckToken')
    ;
});
