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

    //Auth customer
    Route::get('customer_index', 'AuthCustomer@index')->name('customer_index');
    Route::get('customer_create', 'AuthCustomer@create')->name('customer_create');
    Route::post('customer_store', 'AuthCustomer@store')->name('customer_store');
    Route::get('customer_edit/{id}', 'AuthCustomer@edit')->name('customer_edit');
    Route::post('customer_update', 'AuthCustomer@update')->name('customer_update');
    Route::get('customer_destroy/{id}', 'AuthCustomer@destroy')->name('customer_destroy');


    // Mortage
    Route::delete('mortages/destroy', 'MortageController@massDestroy')->name('mortages.massDestroy');
    Route::resource('mortages', 'MortageController');
    Route::get('mortage', 'MortageController@index')->name('mortageindex');

    // Detail
    Route::get('detail', 'detailController@detail')->name('summary');
    Route::post('paid', 'detailController@paid')->name('paid');

    //customer
    Route::get('customer', 'customerController@index')->name('customerindex');
    Route::post('paymentstore', 'customerController@store')->name('paymentstore');

     //Auto Loan
     Route::get('index', 'loanController@index')->name('loanindex');
     Route::get('create', 'loanController@create')->name('loancreate');
     Route::post('loanstore', 'loanController@store')->name('loanstore');
     Route::get('edit/{id}', 'loanController@edit')->name('loanedite');
     Route::post('loanUpdate', 'loanController@update')->name('loaneupdate');
     Route::get('delete/{id}', 'loanController@destroy')->name('loandelete');

     //Auto loan list
    Route::get('loandetail', 'loanlistController@index')->name('loanlist');
    Route::post('loan_paid', 'loanlistController@show')->name('loan_paid');


    //Auto loan customer
    Route::get('loancustomer', 'loanCustomerController@index')->name('loancustomerindex');
    Route::post('store', 'loanCustomerController@store')->name('autopaymentstore');
     Route::post('loanstore', 'loanController@store')->name('loanstore');



    // Balloon Loan routes
    Route::get('balloon_index', 'BalloonController@index')->name('balloon_index');
    Route::get('balloon_create', 'BalloonController@create')->name('balloon_create');
    Route::post('balloonstore', 'BalloonController@store')->name('balloonstore');
    Route::get('balloon_delete/{id}', 'BalloonController@destroy')->name('balloon_delete');


   //Balloon loan list
   Route::get('balloon_summary', 'BalloonInstallmentController@index')->name('balloon_summary');
   Route::post('store', 'BalloonInstallmentController@store')->name('balloonpaymentstore');
   Route::post('Balloon/Paid', 'BalloonInstallmentController@balloon_paid_installment')->name('balloon_paid_installment');


    //bank
    Route::get('bank_index', 'bankControlller@index')->name('bank_index');
    Route::get('bank_create', 'bankControlller@create')->name('bank_create');
    Route::post('bank_store', 'bankControlller@store')->name('bank_store');
    Route::get('bank_destroy/{id}', 'bankControlller@destroy')->name('bank_destroy');
    Route::get('trans_history/{id}', 'bankControlller@history');
    Route::post('del_history', 'bankControlller@delhistory')->name('del_history');



    //Bank transaction
    Route::get('transaction/{id}', 'bankTransacControlller@create');
    Route::post('add_balance', 'bankTransacControlller@store')->name('add_balance');
    Route::get('send_balance/{id}', 'bankTransacControlller@show')->name('send_balance');
    Route::post('share_balance', 'bankTransacControlller@share')->name('share_balance');




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
