<?php

use Doctrine\DBAL\Schema\Index;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});
//logout
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes(['register' => false]);
Route::get('sendmail', 'testController@send');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('transaction', 'HomeController@transaction');
    // Permissions
    Route::resource('permissions', 'PermissionsController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);
    Route::get('permissions', 'PermissionsController@index')->name('permissions.index');

    // Roles
    Route::resource('roles', 'RolesController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);
    Route::get('roles', 'RolesController@index')->name('roleindex');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::get('users', 'UsersController@index')->name('usersindex');


    
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});