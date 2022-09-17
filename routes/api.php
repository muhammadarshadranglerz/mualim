<?php

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::post('Register', 'Api\AuthController@register');
Route::post('forgot_password', 'Api\AuthController@forgot_password');
Route::get('token_confirm/{token}', 'Api\AuthController@tokenConfirm')->name('token_confirm');
Route::get('password_change', 'Api\AuthController@submitResetPassword')->name('password_change');
Route::get('all/subjects', 'Api\SubjectController@index');

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('subject', 'Api\SubjectController@subject');
    Route::post('chapter', 'Api\SubjectController@chapter');

    Route::get('logout', 'Api\AuthController@logout');

});
