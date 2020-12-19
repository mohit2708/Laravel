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

 // Route::get('/', function () {
 //        return view('home');
 //    })->middleware('auth');

 Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/registeruser', 'Auth\RegisterController@doRegister')->name('registeruser');
Route::post('/login', 'Auth\LoginController@doLogin');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::group(['middleware' => ['auth', 'admin']], function(){
Route::get('/admin-dashboard', 'AdminController@adminDashboard')->name('admin-dashboard');
Route::get('/admin-dashboard/delete/{id}', 'AdminController@delete');
Route::get('/admin-dashboard/{id}/edit', 'AdminController@update')->name('admin-dashboard.update');
Route::post('/admin-dashboard/{id}', 'AdminController@edit')->name('admin-dashboard.edit');
Route::get('/status', 'AdminController@status')->name('status');

Route::get('/route-opertion', 'RouteOperationController@index')->name('routeopertion');
//Route::get('/get-tunnel-id', 'RouteOperationController@getTunnelIp')->name('gettunnelip');
Route::post('/route-opertion/store', 'RouteOperationController@routeStore')->name('routestore');

Route::get('/device-info', 'DeviceInfoController@index')->name('device-info');
Route::post('/demo/store', 'ConnectionController@demoStore')->name('demostore');

Route::get('/route-list', 'RouteListController@index')->name('route-list');
Route::get('/operation-data', 'RouteListController@getOpertianRoute')->name('operation-data');
Route::post('/operation-update', 'RouteListController@OpertionUpdate')->name('operation-update');

Route::get('/open-vpn', 'OpenVpnController@index')->name('open-vpn');
Route::post('/export-file', 'OpenVpnController@exportData');

Route::get('/ip-info', 'IpInfoController@index')->name('ip-info');
Route::get('/get-ip-opertion', 'IpInfoController@getIpOpertion');
Route::post('/ipoperation-delete', 'IpInfoController@deleteIpOpertion')->name('ipoperation-delete');

//Route::get('/ip-info', 'IpInfoController@index');
Route::post('/ip-info/store', 'IpInfoController@IPStore')->name('ipstore');
Route::get('/ip-info/ajaxinterface', 'IpInfoController@InterfaceAjax')->name('ajax-interface');

Route::get('/ip-rules', 'IpInfoController@showIpRules')->name('ip-rules');

Route::get('/interface-details', 'InterFaceController@index')->name('interface-details');
Route::get('/wan-interface', 'InterFaceController@indexWanInterface')->name('wan-interface');
Route::post('/wan-interface/store', 'InterFaceController@wanInterfaceStore')->name('wan=interface-store');
Route::get('/waninterface-data', 'InterFaceController@getWebInterface')->name('waninterface-data');
Route::post('/waninterface-update', 'InterFaceController@WanInterfaceUpdate')->name('waninterface-update');
});