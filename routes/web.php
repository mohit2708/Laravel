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
    return view('welcome');
})->middleware('auth');

/*
Login Page set in root url
*/
// Route::get('/', function () {
//     return view('welcome');
// })->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
#Employee List
Route::get('/admin/employee', 'admin\EmployeeController@index')->name('employee');
Route::get('/admin/employee/add', 'admin\EmployeeController@add')->name('employee');
Route::post('/admin/employee/store', 'admin\EmployeeController@store');
Route::get('/admin/employee/edit/{id}', 'admin\EmployeeController@edit');
Route::post('/admin/employee/update/{id}', 'admin\EmployeeController@update');
Route::get('/admin/employee/delete/{id}', 'admin\EmployeeController@delete');


Route::post('/ajax/state/', 'admin\EmployeeController@fetchState');
