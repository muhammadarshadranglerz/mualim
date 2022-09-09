<?php

// Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api', 'middleware' => ['auth:sanctum']], function () {
//     // Mortage
//     Route::get('index','AuthController@index');
// });

Route::get('register','Api\AuthController@register');
Route::get('login','Api\AuthController@login');

Route::group(['namespace' => 'Api', ['middleware' => 'auth:sanctum']], function () {

});