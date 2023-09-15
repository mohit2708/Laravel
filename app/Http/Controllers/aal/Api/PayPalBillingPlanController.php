<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use PayPal\Api\Plan;

use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;

class PayPalBillingPlanController extends Controller
{

    /*
    * Create Billing Plan through API end point.
    */
    public function createPlan(Request $request){
        // $token = $this->getAccessToken();
        $token = (new PayPalTokenController)->getAccessToken();
        // $apiContext = (new PayPalTokenController)->getApiContext();

        // // Create a new currency object
        // $currency = new Currency();
        // $currency->setCurrency('USD');

        // // Create a new payment definition object
        // $paymentDefinition = new PaymentDefinition();
        // $paymentDefinition->setName('Regular Payment')
        //     ->setType('REGULAR')
        //     ->setFrequency('MONTH')
        //     ->setFrequencyInterval('1')
        //     ->setCycles('12') // Number of billing cycles
        //     ->setAmount(new Currency(array('value' => 9.99, 'currency' => 'USD')));

        // // Create a new merchant preferences object
        // $merchantPreferences = new MerchantPreferences();
        // $merchantPreferences->setReturnUrl('https://example.com/return')
        //     ->setCancelUrl('https://example.com/cancel')
        //     ->setAutoBillAmount('yes')
        //     ->setInitialFailAmountAction('CONTINUE')
        //     ->setMaxFailAttempts('0')
        //     ->setSetupFee(new Currency(array('value' => 1.00, 'currency' => 'USD')));

        // // Create a new plan object
        // $plan = new Plan();
        // $plan->setName('Monthly Subscription Plan')
        //     ->setDescription('Monthly subscription plan for auto top-up')
        //     ->setType('FIXED')
        //     ->setState('ACTIVE')
        //     ->setPaymentDefinitions(array($paymentDefinition))
        //     ->setMerchantPreferences($merchantPreferences);

        // // Create the plan on PayPal
        // try {
        //     $createdPlan = $plan->create($apiContext);

        //     // Output the created plan ID
        //     echo 'Created Plan ID: ' . $createdPlan->getId();
        // } catch (Exception $e) {
        //     // Handle errors
        //     echo 'Error: ' . $e->getMessage();
        // }

        // dd('asf');
       
        if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal.'], 500);
        }

        $plan = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'type' => 'INFINITE', // Change this to 'FIXED' if you want a fixed number of payments
            'payment_definitions' => [
                [
                    'name' => 'Regular Payment',
                    'type' => $request->input('type'),
                    'frequency_interval' => 1, // e.g., 1 for every interval
                    'frequency' => 'DAY', // e.g., 'DAY', 'MONTH' for monthly, 'WEEK' for weekly
                    'amount' => [
                        'currency' => 'USD', // Change this if you're using a different currency
                        'value' => $request->input('amount'),
                    ],
                ],
            ],
            'merchant_preferences' => [
                'return_url' => route('paypal.create-agreement'),
                'cancel_url' => route('paypal.cancel'),
                'auto_bill_amount' => 'YES', // Set 'NO' to require user approval for each billing cycle
            ],
        ];
        
        $response = Http::withToken($token)->post(config('paypal.base_url').'/v1/payments/billing-plans', $plan);
        // $response = Http::withToken($token)->post(config('paypal.base_url').'/v1/billing/plans', $plan);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to create the billing plan.'], 500);
        }

        $planId = $response->json('id');
        return response()->json(['plan_id' => $planId]);
    }


    /*
    * List of Billing Plan through API end point.
    */
    public function listBillingPlans(){
        $token = (new PayPalTokenController)->getAccessToken();

        if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal.'], 500);
        }

        // $response = Http::withToken($token)->get(config('paypal.end_point').'/v1/payments/billing-plans');
        $response = Http::withToken($token)->get(config('paypal.end_point').'/v1/billing/plans?page_size=10&page=1&total_required=true');

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch billing plans.'], 500);
        }

        $billingPlans = $response->json();

        return response()->json(['billing_plans' => $billingPlans]);
    }


    /*
    * Show of Billing Plan through API end point.
    */
    public function showBillingPlan(Request $request)
    {
        $token = (new PayPalTokenController)->getAccessToken();
        $planId = $request->input('plan_id');

        if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal.'], 500);
        }

        $response = Http::withToken($token)->get(config('paypal.base_url').'/v1/payments/billing-plans/'.$planId);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch billing plan details.'], 500);
        }

        $billingPlan = $response->json();

        return response()->json(['billing_plan' => $billingPlan]);
    }

    /*
    * Delete of Billing Plan through API end point.
    */
    public function deleteBillingPlan(Request $request)
    {
        $token = (new PayPalTokenController)->getAccessToken();
        $planId = $request->input('plan_id');

        if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal.'], 500);
        }

        $response = Http::withToken($token)->delete(config('paypal.base_url').'/v1/payments/billing-plans/'.$planId);
        // dd($response);

        if ($response->failed()) {
            $errorDetails = $response->json();
            // Log the error details for debugging
            Log::error('PayPal API Error:', $errorDetails);
            return response()->json(['error' => 'Failed to delete the billing plan.'], 500);
        }

        return response()->json(['message' => 'Billing plan deleted successfully.']);
    }


    /*
    * Create Plan For inbuild package reccuring plan
    */
    public function createPlanib(Request $request){
  
        $plan = new Plan();
        $plan->setName('T-Shirt of the Month Club Plan')
            ->setDescription('Template creation.')
            ->setType('fixed');

        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("1")
            ->setCycles("12")
            ->setAmount(new Currency(array('value' => 100, 'currency' => 'USD')));  
            

        $chargeModel = new ChargeModel();
        $chargeModel->setType('SHIPPING')
            ->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));
        
        $paymentDefinition->setChargeModels(array($chargeModel));


        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl(route('paypal.create-agreement'))
            ->setCancelUrl(route('paypal.cancel'))
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);
        $request = clone $plan;

        try {
            $output = $plan->create($this->apiContext());       
            return response()->json(['message' => 'Plan created successfully.', 'plan_id' => $output->getId()]);
        } catch (PayPalConnectionException $ex) {
            // PayPal API error
            $errorDetails = $ex->getData();
            return response()->json(['error' => 'Failed to create the plan.', 'error_details' => $errorDetails], 500);
        } catch (Exception $ex) {
            // Other general exception
            return response()->json(['error' => 'Failed to create the plan.', 'error_details' => $ex->getMessage()], 500);
        }
        

    }

    /*
    * Update Plan For inbuild package reccuring plan
    */
    public function updatePlanib(Request $request){
            // "plan_id" : "P-29R34689HY500430LTQHMEFI"
            // "plan_id" : "P-006734860J891803LTQIDJLA"
        // try {
            $apiContext = (new PayPalTokenController)->getApiContext();
            $planId = $request->input('plan_id');
            // try {
                $plan = Plan::get($planId, $apiContext);
                
                // Create a new Patch object to update the plan's state
                $patch = new Patch();
                $value = new PayPalModel('{
                    "state":"ACTIVE"
                }');
                $patch->setOp('replace')
                    ->setPath('/')
                    ->setValue($value);
                
                    $patchRequest = new PatchRequest();
                    $patchRequest->addPatch($patch);
                    
                    // Update the plan's state
                    $plan->update($patchRequest, $apiContext);
                    // dd($plan);
    
                return response()->json([
                    'message' => 'Plan updated to active state',
                    'plan' => $planId,
                ]);
    }

    /*
    * Delete Plan For inbuild package reccuring plan
    */
    public function DeletePlanib(Request $request){
        $request->validate([
            'plan_id' => 'required',
        ]);
        $apiContext = (new PayPalTokenController)->getApiContext();
        $planId = $request->plan_id;


        try {
            // Get the billing plan object by the provided plan ID
            $createdPlan = Plan::get($planId, $apiContext);

            // Delete the billing plan
            $result = $createdPlan->delete($apiContext);

            return response()->json(['message' => 'Plan deleted successfully.', 'plan_id' => $planId]);
        } catch (PayPalConnectionException $ex) {
            // Handle PayPal API connection errors or HTTP 400 errors
            if ($ex->getCode() === 404) {
                // Plan ID not found (HTTP 404 status code)
                return response()->json(['error' => 'Plan ID does not exist.'], 404);
            } else {
                $errorDetails = $ex->getData();
                return response()->json(['error' => 'Failed to delete the plan.', 'error_details' => $errorDetails], 500);
            }
        } catch (Exception $ex) {
            // Other general exception
            return response()->json(['error' => 'Failed to delete the plan.', 'error_details' => $ex->getMessage()], 500);
        }
    }

    public function handleIPN(Request $request)
    {
        // Verify IPN request and process data
        // You should validate the IPN request and update your database accordingly
        // Example: Log IPN data
        Log::info('IPN Received:', $request->all());
    }



}
