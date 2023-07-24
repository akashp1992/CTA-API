<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'customer', 'middleware' => 'check.organization'], function () {

    Route::post('login', 'API\Customer\AuthController@login');
    Route::post('register', 'API\Customer\AuthController@register');

    Route::group(['prefix' => 'password'], function () {
        Route::post('reset', 'API\Customer\AuthController@resetPassword');
        Route::post('update', 'API\Customer\AuthController@updatePassword');
    });
    
    Route::get('service/categories', 'API\Customer\ServiceCategoryController@getServiceCategories');
    Route::get('report/ticket/types', 'API\Customer\ServicesController@getSalesByTicketTypeReport');
    Route::get('branches', 'API\Customer\BranchController@getBranches');

    Route::group(['middleware' => 'customer.check'], function () {
        Route::get('resend/otp', 'API\Customer\AuthController@resendOTP');
        Route::post('verify/otp', 'API\Customer\AuthController@verifyOTP');
        Route::get('profile', 'API\Customer\AuthController@getProfile');
        Route::post('booking', 'API\Customer\BookingController@store');

        Route::post('profile/update', 'API\Customer\AuthController@updateProfile');
        Route::post('change/password', 'API\Customer\AuthController@changePassword');
        Route::get('deactivate', 'API\Customer\AuthController@deactivate');
        Route::post('logout', 'API\Customer\AuthController@logout');
        
    });
});
