<?php

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
    return view('auth.login');
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/home', 'HomeController@index')->name('home');

// Route::group(['middleware' => 'admin'], function () {
Route::get('/blank', 'Admin\BlankController@index')->name('blank');

// For User Route
Route::get('/user-list', 'Admin\UserListConroller@index')->name('user-list');

#employee Route
Route::get('/employee', 'Admin\EmployeeController@index');
Route::get('/employee/add', 'Admin\EmployeeController@add');
Route::post('/employee/store', 'Admin\EmployeeController@store');



#Package Feature
// Route::get('package/feature', 'Admin\PackageFeatureController@index');
// Route::get('package/feature/add', 'Admin\PackageFeatureController@add');
// Route::post('package/feature/store', 'Admin\PackageFeatureController@store');
// Route::get('package/feature/edit/{id}', 'Admin\PackageFeatureController@edit');
// Route::post('package/feature/update/{id}', 'Admin\PackageFeatureController@update');
// Route::get('package/feature/delete/{id}', 'Admin\PackageFeatureController@delete');
// Route::get('package/feature/status/{id}', 'Admin\PackageFeatureController@features_status');

// });

