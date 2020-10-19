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
});
//Auth::routes();

Route::get('register', 'Auth\RegisterController@register')->name('register');
Route::post('register', 'Auth\RegisterController@doRegister')->name('register');

Route::get('login', 'Auth\LoginController@login')->name('login');
Route::post('login', 'Auth\LoginController@doLogin');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth', 'admin']], function(){
Route::get('admin-deshboard', 'Auth\AdminController@index')->name('admin-deshboard');
});

Route::get('status', 'Auth\AdminController@status')->name('status');

Route::get('home', 'HomeController@home')->name('home');

Route::get('forget-password', 'Auth\ForgotPasswordController@getEmail');
Route::post('forget-password', 'Auth\ForgotPasswordController@postEmail');

// Route::group(['middleware'  => ['auth','admin']], function () {
	// Route::get('/dashboard', 'Admin\AdminController@index');
	// Route::get('/user-list', 'Admin\AdminController@userList');
	// Route::get('/register-user', 'Admin\AdminController@registerUser');
	// Route::post('/registeruser', 'Admin\AdminController@storeUser')->name('registeruser'); 
	// Route::delete('/user-delete/{id}', 'Admin\AdminController@deleteUser');   
	// Route::get('/getUserData', 'Admin\AdminController@getUserData');
	// Route::post('/updateUserData', 'Admin\AdminController@updateUserData');
	// Route::post('/updateUserStatus', 'Admin\AdminController@updateUserStatus');
	// Route::get('/upload-file', 'Admin\AdminController@uploadFiles');
	// Route::post('/upload-project', 'Admin\AdminController@uploadProject');
	// Route::get('/project-list', 'Admin\AdminController@projectLists');
// });


