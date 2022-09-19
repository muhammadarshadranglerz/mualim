<?php

use App\Http\Controllers\Admin\SubjectController;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
    return 'Application cache cleared!';
});
Route::get('/migrate', function () {
    Artisan::call('migrate:fresh --seed');
    return 'database updated successfully!';
});


Route::get('/', function(){
    return redirect()->route('admin.home');
});

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});
//logout
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
   
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::post('status', 'UsersController@status')->name('status');
    //subject
    Route::resource('subject', 'SubjectController');
    //chapter
    Route::resource('chapter', 'ChapterController');
    //question answer
    Route::resource('question-answer', 'QuestionAnswerController');
    // Route::get('users', 'UsersController@index')->name('usersindex');


    
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

// ROute::prefix('subject')->group(function(){
//     Route::get('/',SubjectController::class,'index');
// });