<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('set/locale/{locale?}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        \Illuminate\Support\Facades\Session::put('locale', $locale);
    }
    return \Illuminate\Support\Facades\Redirect::back();
})->name('set.locale');

Auth::routes(['verify' => false, 'register' => false]);

Route::get('401', 'HomeController@error401')->name('401');
Route::post('validate/unique', 'HomeController@validateUnique')->name('validate.unique');
Route::get('select/organization', 'HomeController@selectOrganization')->name('select.organization');

Route::group(['middleware' => ['auth', 'verified', 'check.access']], function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('profile', 'HomeController@profile')->name('profile');
    Route::get('change-password', 'HomeController@changePassword')->name('change_password');
    Route::post('update-password', 'HomeController@updatePassword')->name('update_password');
    Route::get('remove/file', 'HomeController@removeFile')->name('remove.file');
    Route::get('state/update', 'HomeController@updateState')->name('state.update');
    Route::get('customers/detail', 'CustomersController@getCustomerByPhone')->name('customers.detail');

    Route::resource('users', 'UsersController');
    Route::resource('customers/{slug}/addresses', 'CustomerAddressesController')->except(['index']);
    Route::get('customers/ajax', 'CustomersController@getCustomers')->name('customers.ajax');
    Route::resource('customers', 'CustomersController');
    
    Route::resource('companies', 'CompaniesController');
    // Route::resource('banners', 'BannersController');
    Route::resource('pages', 'PagesController');


    Route::get('/backup_database', 'HomeController@databaseBackup')->name('backup_database');

    // Administrative Routes
    Route::resource('organizations', 'OrganizationsController');
    // Route::resource('groups', 'GroupsController');

    Route::group(['prefix' => 'configurations'], function () {
        Route::get('', 'ConfigurationsController@index')->name('configurations.index');
        Route::post('update', 'ConfigurationsController@update')->name('configurations.update');
    });

});


