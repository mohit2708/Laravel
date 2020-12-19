<?php

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
#Login Page
Route::get('/', function () { return view('login'); });
Route::post('login', array('as' => 'adminlogin', 'uses' => 'Auth\LoginController@doLogin'));
Route::get('logout', array('as' => 'adminlogout', 'uses' => 'Auth\LoginController@doLogout'));

# Admin Area
Route::group([ 'prefix' => 'admin', 'middleware' => ['auth.admin']], function(){
	
#Dashboard	
Route::any('/', array('as' => 'admindashboard','uses' => 'HomeController@adminDashboard'));

#Setting
Route::any('/setting', array('as' => 'adminsetting', 'uses' => 'Admin\SettingController@setting'));

#Module Routes
Route::get('acl/module', array('as' => 'listmodule','uses' => 'Admin\ModuleController@index'));
Route::get('acl/module/add', array('as' => 'addmodule','uses' => 'Admin\ModuleController@add'));
Route::post('acl/module/store', array('as' => 'storemodule','uses' => 'Admin\ModuleController@store'));
Route::get('acl/module/edit/{id}', array('as' => 'editmodule','uses' => 'Admin\ModuleController@edit'));
Route::post('acl/module/update/{id}', array('as' => 'updatemodule','uses' => 'Admin\ModuleController@update'));

#Page Routes
Route::get('acl/page', array('as' => 'listpage','uses' => 'Admin\PageController@index'));
Route::get('acl/page/add', array('as' => 'addpage','uses' => 'Admin\PageController@add'));
Route::post('acl/page/store', array('as' => 'storepage','uses' => 'Admin\PageController@store'));
Route::get('acl/page/edit/{id}', array('as' => 'editpage','uses' => 'Admin\PageController@edit'));
Route::post('acl/page/update/{id}', array('as' => 'updatepage','uses' => 'Admin\PageController@update'));
#AJAX Call
Route::post('acl/page/ajax', array('as' => 'ajaxpage','uses' => 'Admin\PageController@ajaxRoleModule'));

	
#Page Access ACL
Route::get('acl/page_access', array('as' => 'listacl','uses' => 'Admin\AclPageAccessController@index'));
Route::post('acl/page_access/store', array('as' => 'updateacl','uses' => 'Admin\AclPageAccessController@store'));
Route::post('acl/page_access/edit', array('as' => 'editacl','uses' => 'Admin\AclPageAccessController@edit'));

#Bonus Management
Route::get('bonus', array('as' => 'bonuslist', 'uses' => 'Admin\BonusController@index'));
Route::post('bonus/referral', array('as' => 'bonusreferal', 'uses' => 'Admin\BonusController@referral'));
Route::post('bonus/travel', array('as' => 'bonusreferal', 'uses' => 'Admin\BonusController@travel'));

#Currency Routes
Route::get('currency', array('as' => 'listcurrency','uses' => 'Admin\CurrencyController@index'));
Route::get('currency/add', array('as' => 'addcurrency','uses' => 'Admin\CurrencyController@add'));
Route::post('currency/store', array('as' => 'storecurrency','uses' => 'Admin\CurrencyController@store'));
Route::get('currency/edit/{id}', array('as' => 'editcurrency','uses' => 'Admin\CurrencyController@edit'));
Route::get('currency/delete/{id}', array('as' => 'deletecurrency','uses' => 'Admin\CurrencyController@delete'));
Route::post('currency/update/{id}', array('as' => 'updatecurrency','uses' => 'Admin\CurrencyController@update'));

#Services Routes
Route::get('service', array('as' => 'listservice','uses' => 'Admin\ServicesController@index'));
Route::get('service/add', array('as' => 'addservice','uses' => 'Admin\ServicesController@add'));
Route::post('service/store', array('as' => 'storeservice','uses' => 'Admin\ServicesController@store'));
Route::get('service/edit/{id}', array('as' => 'editservice','uses' => 'Admin\ServicesController@edit'));
Route::get('service/delete/{id}', array('as' => 'deleteservice','uses' => 'Admin\ServicesController@delete'));
Route::post('service/update/{id}', array('as' => 'updateservice','uses' => 'Admin\ServicesController@update'));
Route::get('service/status/{id}', array('as' => 'statusservice','uses' => 'Admin\ServicesController@status'));

#Coupons Routes
Route::get('coupon', array('as' => 'listcoupon','uses' => 'Admin\CouponController@index'));
Route::get('coupon/add', array('as' => 'addcoupon','uses' => 'Admin\CouponController@add'));
Route::post('coupon/store', array('as' => 'storecoupon','uses' => 'Admin\CouponController@store'));
Route::get('coupon/edit/{id}', array('as' => 'editcoupon','uses' => 'Admin\CouponController@edit'));
Route::get('coupon/delete/{id}', array('as' => 'deletecoupon','uses' => 'Admin\CouponController@delete'));
Route::post('coupon/update/{id}', array('as' => 'updatecoupon','uses' => 'Admin\CouponController@update'));
Route::get('coupon/status/{id}', array('as' => 'statuscoupon','uses' => 'Admin\CouponController@status'));


#Discount Management
Route::get('discount', array('as' => 'discountlist', 'uses' => 'Admin\DiscountController@index'));

#Discount Coupon
Route::get('discount/coupon', array('as' => 'discountcoupon', 'uses' => 'Admin\DiscountController@discountCoupon'));
Route::get('discount/coupon/add', array('as' => 'discountcouponadd', 'uses' => 'Admin\DiscountController@addDiscountCoupon'));
Route::post('discount/coupon/store', array('as' => 'discountcouponstore', 'uses' => 'Admin\DiscountController@storeDiscountCoupon'));
Route::get('discount/coupon/edit/{id}', array('as' => 'discountcedit', 'uses' => 'Admin\DiscountController@editDiscountCoupon'));	
Route::post('discount/coupon/update/{id}', array('as' => 'discountcupdate', 'uses' => 'Admin\DiscountController@updateDiscountCoupon'));
Route::get('discount/coupon/delete/{id}', array('as' => 'discountcdelete', 'uses' => 'Admin\DiscountController@deleteDiscountCoupon'));	

#Discount Offer
Route::get('discount/offer', array('as' => 'discountoffer', 'uses' => 'Admin\DiscountController@discountOffer'));
Route::get('discount/offer/add', array('as' => 'discountofferadd', 'uses' => 'Admin\DiscountController@addDiscountOffer'));
Route::post('discount/offer/store', array('as' => 'discountofferstore', 'uses' => 'Admin\DiscountController@storeDiscountOffer'));
Route::get('discount/offer/edit/{id}', array('as' => 'discountoedit', 'uses' => 'Admin\DiscountController@editDiscountOffer'));	
Route::post('discount/offer/update/{id}', array('as' => 'discountoupdate', 'uses' => 'Admin\DiscountController@updateDiscountOffer'));
Route::get('discount/offer/delete/{id}', array('as' => 'discountodelete', 'uses' => 'Admin\DiscountController@deleteDiscountOffer'));

#Discount Category
Route::get('discount/category', 'Admin\DiscountCategoryController@index');
Route::get('discount/category/add', 'Admin\DiscountCategoryController@add');
Route::post('discount/category/store', 'Admin\DiscountCategoryController@store');
Route::get('discount/category/edit/{id}', 'Admin\DiscountCategoryController@edit');
Route::post('discount/category/update/{id}', 'Admin\DiscountCategoryController@update');
Route::get('discount/category/delete/{id}', 'Admin\DiscountCategoryController@delete');

#Package Feature
Route::get('package/feature', 'Admin\PackageFeatureController@index');
Route::get('package/feature/add', 'Admin\PackageFeatureController@add');
Route::post('package/feature/store', 'Admin\PackageFeatureController@store');
Route::get('package/feature/edit/{id}', 'Admin\PackageFeatureController@edit');
Route::post('package/feature/update/{id}', 'Admin\PackageFeatureController@update');
Route::get('package/feature/delete/{id}', 'Admin\PackageFeatureController@delete');
Route::get('package/feature/status/{id}', 'Admin\PackageFeatureController@features_status');

#Package Facility
Route::get('package/facility', 'Admin\PackageFacilityController@index');
Route::get('package/facility/add', 'Admin\PackageFacilityController@add');
Route::post('package/facility/store', 'Admin\PackageFacilityController@store');
Route::get('package/facility/edit/{id}', 'Admin\PackageFacilityController@edit');
Route::post('package/facility/update/{id}', 'Admin\PackageFacilityController@update');
Route::get('package/facility/delete/{id}', 'Admin\PackageFacilityController@delete');

#Package Policy
Route::get('package/policy', 'Admin\PackagePolicyController@index');
Route::get('package/policy/add', 'Admin\PackagePolicyController@add');
Route::post('package/policy/store', 'Admin\PackagePolicyController@store');
Route::get('package/policy/edit/{id}', 'Admin\PackagePolicyController@edit');
Route::post('package/policy/update/{id}', 'Admin\PackagePolicyController@update');
Route::get('package/policy/delete/{id}', 'Admin\PackagePolicyController@delete');

#Master City
Route::get('master/city', 'Admin\CityController@index');
Route::get('master/city/add', 'Admin\CityController@add');
Route::post('master/city/store', 'Admin\CityController@store');
Route::get('master/city/edit/{id}', 'Admin\CityController@edit');
Route::post('master/city/update/{id}', 'Admin\CityController@update');
Route::get('master/city/delete/{id}', 'Admin\CityController@delete');
Route::post('master/city/ajax', 'Admin\CityController@ajaxCity');

#Master Airlines
Route::get('master/airlines', 'Admin\AirlinesController@index');
Route::get('master/airlines/add', 'Admin\AirlinesController@add');
Route::post('master/airlines/store', 'Admin\AirlinesController@store');
Route::get('master/airlines/edit/{id}', 'Admin\AirlinesController@edit');
Route::post('master/airlines/update/{id}', 'Admin\AirlinesController@update');
Route::get('master/airlines/delete/{id}', 'Admin\AirlinesController@delete');
Route::post('master/airlines/ajax', 'Admin\AirlinesController@ajaxCity');

#Master Deals
Route::get('deals', 'Admin\DealsController@index');
Route::get('deals/add', 'Admin\DealsController@add');
Route::post('deals/store', 'Admin\DealsController@store');
Route::get('deals/edit/{id}', 'Admin\DealsController@edit');
Route::post('deals/update/{id}', 'Admin\DealsController@update');
Route::get('deals/delete/{id}', 'Admin\DealsController@delete');



#package

Route::get('package', array('as' => 'package','uses' => 'Admin\PackageController@create'));
Route::post('package/store', array('as' => 'package','uses' => 'Admin\PackageController@package_store'));
Route::get('package/list', array('as' => 'package/list','uses' => 'Admin\PackageController@index'));
Route::get('package/edit/{id}', array('as' => 'package/edit','uses' => 'Admin\PackageController@package_edit'));
Route::post('package/update', array('as' => 'package/update','uses' => 'Admin\PackageController@package_update'));
Route::post('itinarary/delete', array('as' => 'package/list','uses' => 'Admin\PackageController@itinarary_delete'));
Route::post('itinarary/image/delete', array('as' => 'itinarary/image/delete','uses' => 'Admin\PackageController@itinarary_image_delete'));
Route::post('package/image/delete', array('as' => 'package/image/delete','uses' => 'Admin\PackageController@package_image_delete'));
Route::get('package/status/{id}', array('as' => 'package/image/delete','uses' => 'Admin\PackageController@package_status'));





});

