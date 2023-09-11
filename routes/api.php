<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    // Route::post('/refresh', [AuthController::class, 'refresh']);
    // Route::get('/user-profile', [AuthController::class, 'userProfile']); 
});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('/logout', [AuthController::class, 'logout']);

    # campaign routes
    // Route::get('/campaign', [CampaignController::class, 'index']);
    // Route::post('/campaign/store', [CampaignController::class, 'store']);
    // Route::get('/campaign/list', [CampaignController::class, 'getCampaignList']);
    // Route::get('/campaign/show', [CampaignController::class, 'show']);
    // Route::post('/campaign/update', [CampaignController::class, 'update']);
    // Route::post('/campaign/destroy', [CampaignController::class, 'destroy']);
    // Route::get('/campaign/industry-types', [CampaignController::class, 'industryTypes']);
    
});
