<?php

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::post('Register', 'Api\AuthController@register');
Route::post('forgot_password', 'Api\AuthController@forgot_password');
Route::get('token_confirm/{token}', 'Api\AuthController@tokenConfirm')->name('token_confirm');
Route::get('password_change', 'Api\AuthController@submitResetPassword')->name('password_change');

Route::group(['middleware' => 'auth:sanctum'], function () {
    
    Route::get('all/subjects', 'Api\SubjectController@index');
    Route::post('subjects', 'Api\SubjectController@subject');
    Route::post('chapter', 'Api\SubjectController@chapter');
    Route::post('quiz', 'Api\SubjectController@quiz');
    Route::post('email', 'Api\AuthController@email');
    Route::get('profile', 'Api\ProfileController@index');
    Route::post('profile', 'Api\ProfileController@update');
    Route::get('report', 'Api\ReportController@index');
    Route::post('status', 'Api\StatusController@status');
    Route::post('status/store', 'Api\StatusController@statusStore');
    Route::post('score', 'Api\StatusController@score');
    Route::post('score/store', 'Api\StatusController@scoreStore');

    Route::get('logout', 'Api\AuthController@logout');

});
