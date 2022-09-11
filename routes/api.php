<?php

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::post('forgot_password', 'Api\AuthController@forgot_password');
Route::get('token_confirm/{token}', 'Api\AuthController@tokenConfirm')->name('token_confirm');
Route::get('password_change', 'Api\AuthController@submitResetPassword')->name('password_change');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('subjects', 'Api\SubjectController@index');
    Route::get('logout', 'Api\AuthController@logout');

});
