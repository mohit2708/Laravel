<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\AuthorizeNetController;
use App\Http\Controllers\Api\PayPalController;
use App\Http\Controllers\Api\PayPalBillingPlanController;
use App\Http\Controllers\Api\PayPalInbuildPackageController;
use App\Http\Controllers\Api\Leads\MCALeadsController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('/logout', [AuthController::class, 'logout']);

    # campaign routes
    Route::get('/campaign', [CampaignController::class, 'index']);
    Route::post('/campaign/store', [CampaignController::class, 'store']);
    Route::get('/campaign/list', [CampaignController::class, 'getCampaignList']);
    Route::get('/campaign/show', [CampaignController::class, 'show']);
    Route::post('/campaign/update', [CampaignController::class, 'update']);
    Route::post('/campaign/destroy', [CampaignController::class, 'destroy']);
    Route::get('/campaign/industry-types', [CampaignController::class, 'industryTypes']);
    
});


Route::post('/leads/mca', [MCALeadsController::class, 'getMCAPaperList']);
Route::post('/leads/mca/live', [MCALeadsController::class, 'getMCALiveLeadsList']);

# AuthorizeNetController APIs
Route::post('/payment', [AuthorizeNetController::class, 'processPayment']);
Route::post('/customerstore', [AuthorizeNetController::class, 'store']);
Route::post('/listCard', [AuthorizeNetController::class, 'listCard']);
Route::post('/addCard', [AuthorizeNetController::class, 'addCard']);
Route::post('/createCustomer', [AuthorizeNetController::class, 'createCustomer']);

# PayPalController APIs
Route::post('/getAccessToken', [PayPalController::class, 'getAccessToken']);
Route::post('/paypal/api-request', [PayPalController::class, 'makeApiRequest']);

// getCardList
Route::post('/add-card', [PayPalController::class, 'addCard']);
Route::get('/get-card', [PayPalController::class, 'getCardList']);
Route::get('/getAllCustomersFromPayPal', [PayPalController::class, 'getAllCustomersFromPayPal']);



# test create payment Correct
Route::post('/create-payment', [PayPalController::class, 'createPayment'])->name('paypal.create');
Route::get('/execute-payment', [PayPalController::class, 'executePayment'])->name('paypal.execute');
Route::get('/cancel-payment', [PayPalController::class, 'cancelPayment'])->name('paypal.cancel');

# AutoWalletRecharge
Route::post('/wallet-recharge', [PayPalInbuildPackageController::class, 'AutoWalletRecharge']);
Route::post('/ajeetautowallet', [PayPalInbuildPackageController::class, 'ajeetautowallet']);


# Recurring payment
Route::post('/ipn', [PayPalBillingPlanController::class, 'handleIPN']);
    ## Create Plan
Route::post('/create-plan', [PayPalBillingPlanController::class, 'createPlan']);
Route::post('/create-planib', [PayPalBillingPlanController::class, 'createPlanib']);
    ## List of billing plan
Route::get('/get-billing-plans', [PayPalBillingPlanController::class, 'listBillingPlans']);
    ## Show of billing plan
Route::get('/show-billing-plans', [PayPalBillingPlanController::class, 'showBillingPlan']);
    ## update Billing Plan
Route::post('/update-planib', [PayPalBillingPlanController::class, 'updatePlanib']);
    ## Delete Plan
Route::post('/delete-plan', [PayPalBillingPlanController::class, 'deleteBillingPlan']);
Route::post('/delete-planib', [PayPalBillingPlanController::class, 'DeletePlanib']);




Route::post('/activatePlan', [PayPalController::class, 'activatePlan']);


Route::post('/create-agreement', [PayPalController::class, 'createAgreement'])->name('paypal.create-agreement');
Route::post('/execute-agreement', [PayPalController::class, 'executeAgreement']);


Route::get('/return', [PayPalController::class, 'return']);
Route::get('/cancel', [PayPalController::class, 'cancel']);



Route::post('/paypal/create-authorization', [PayPalController::class, 'createAuthorization']);
Route::post('/createCustomer', [PayPalController::class, 'createCustomer']);

Route::get('/paypal/access-token', [PayPalController::class, 'getAccessToken']);

//  get leads list 
Route::post('/leads/list', [MCALeadsController::class, 'getLeadDetails']);

Route::post('/leads/mca', [MCALeadsController::class, 'getMCAPaperList']);
Route::post('/leads/mca/live', [MCALeadsController::class, 'getMCALiveLeadsList']);



// Route::get('/campaign/create', [CampaignController::class, 'create']);
// Route::get('/campaign/edit', [CampaignController::class, 'edit']);
