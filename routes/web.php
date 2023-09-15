<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return Redirect::to('/login');
});

# User Managment Routes
Route::get('/user/list', [UserController::class, 'index']);
Route::get('/user/create', [UserController::class, 'create']);
// Route::post('/user-management/store', [UserController::class, 'store']);
Route::get('/user/edit/{id}', [UserController::class, 'edit']);
// Route::post('/user-management/update', [UserController::class, 'update']);
// Route::get('/user-management/delete/{id}', [UserController::class, 'delete']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
