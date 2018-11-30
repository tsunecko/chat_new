<?php

Route::group([
    'prefix' => 'api',
    'module'=>'auth',
    'namespace' => 'App\modules\auth\Controllers'
], function() {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::post('login', 'AuthController@login');

    Route::post('register', 'AuthController@register');

    Route::post('reset', 'AuthController@reset');

});
