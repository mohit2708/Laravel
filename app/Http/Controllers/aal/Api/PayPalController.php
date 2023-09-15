<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;
use App\Models\PaymentProfile;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\CreditCard;
use PayPal\Api\Customer;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementSearch;
use PayPal\Api\PayerInfo;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Api\ShippingAddress;
use Carbon\Carbon;
use PayPal\Api\Plan;



use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;


use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;

class PayPalController extends Controller
{
    private $apiEndpoint = 'https://api-m.sandbox.paypal.com';
    private $apiBaseUrl = 'https://api.sandbox.paypal.com'; // Use 'https://api.paypal.com' for live environment
    private $apiVersion = 'v1';
    private $clientId = 'AUsKUKqQ8P7j12NkJuI3Z0JThbso6P9c4TuvbSwmWkEbqkloxGJsAJ9h8meV_I5q7ZlcXPyma-1yD2Tg';
    private $clientSecret = 'EL6IWKl5d7NFfZWdigPJtzQ_5mjj1t74koBHTeimA-RVAOo0df5WXk3LlQPT8zI45ZRQpXeA3Ert251D';

    // private $clientId = 'ATtivEehxIFw83YY6jOwpxrZpEeUJZcedtAxD0R5k4EmvjMUuiw9yFxiy-ye6ctnM74-YYqVcK9TsoBw';
    // private $clientSecret = 'ENV3c0LBWYjT8fDoSPEfS0tjKq8B4oR7RWoQNpq8jZw8ByuTKlhJDXfEP8xfFfZXmyYkleHME5Wi54zp';

    public function getAccessToken()
    {
        $tokenEndpoint = $this->apiEndpoint . '/'.config('paypal.version').'/oauth2/token';
        try {
            $client = new Client();
            $response = $client->post($tokenEndpoint, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Accept-Language' => 'en_US',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
                'auth' => [
                    config('paypal.client_id'),
                    config('paypal.secret'),
                ],
            ]);

            $responseBody = $response->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            if (json_last_error() === JSON_ERROR_NONE && isset($responseData['access_token'])) {
                $accessToken = $responseData['access_token'];
                return $accessToken;
            } else {
                // Handle the case when the response is not in the expected format or is missing 'access_token'
                throw new \RuntimeException('Invalid access token response');
            }
        } catch (ClientException $e) {
            // Log or display the error message and status code
            \Log::error('Error: ' . $e->getMessage());
            \Log::error('Status Code: ' . $e->getCode());
            
            // Optionally, return an error response to the client
            return response()->json(['error' => 'Failed to obtain access token'], 500);
        } catch (\Exception $e) {
            // Handle any other general exceptions
            \Log::error('Error: ' . $e->getMessage());
            
            // Optionally, return an error response to the client
            return response()->json(['error' => 'Unexpected error'], 500);
        }
    }

    public function addCard(Request $request){

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );

        // Create a CreditCard object with card details
        $card = new CreditCard();
        $card->setType($request->input('card_type'))
             ->setNumber($request->input('card_number'))
             ->setExpireMonth($request->input('card_exp_month'))
             ->setExpireYear($request->input('card_exp_year'))
             ->setCvv2($request->input('card_cvv2'))
             ->setFirstName($request->input('first_name'))
             ->setLastName($request->input('last_name'));

        // Associate the card with the payer ID
        $card->setPayerId($request->input('payer_id'));

        try {
            $card->create($apiContext);
            return response()->json(['message' => 'Card added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
   
    }

    public function getCardList(Request $request){
        
        $clientId = $this->clientId;
        $clientSecret = $this->clientSecret;
        
        // Set up the API context with your credentials
        $apiContext = new ApiContext(new OAuthTokenCredential($clientId, $clientSecret));
        $apiContext->setConfig([
            'mode' => 'sandbox', // 'sandbox' for testing, 'live' for production
        ]);
        $payerId = $request->input('payer_id');
        
        try {
            // $payerInfo = PayerInfo::get($payerId, $apiContext);
            // dd($payerInfo);
            // Make the API call to list credit cards associated with the payer
            $cards = CreditCard::all(['payer_id' => $request->input('payer_id')], $apiContext);
            // $cards = CreditCard::get(['payer_id' => $request->input('payer_id')], $apiContext);
            // Now you can access the list of cards in the $cards variable
            $cardList = [];
            foreach ($cards->getItems() as $card) {
                // dd($card);
                // Add card details to the $cardList array
                $cardList[] = [
                    'payer_id' => $card->getPayerId(),
                    'card_id' => $card->getId(),
                    'card_type' => $card->getType(),
                    'card_number' => $card->getNumber(),
                    'card_exp_month' => $card->getExpireMonth(),
                    'card_exp_year' => $card->getExpireYear(),
                    'card_first_name' => $card->getFirstName(),
                    'card_last_name' => $card->getLastName(),
                    // Add other card details as needed
                ];
            }

            return response()->json(['cards' => $cardList]);

        } catch (\Exception $e) {
            // Handle API error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function makeApiRequest(Request $request)
    {
        $accessToken = $this->getAccessToken();
        dd($accessToken);
        $httpMethod = $request->input('http_method');
        $apiPath = $request->input('api_path');
        $requestData = $request->input('request_data', []);

        $apiUrl = $this->apiEndpoint . '/' . $this->apiVersion . '/' . $apiPath;

        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ];

        $client = new Client();
        $response = $client->request($httpMethod, $apiUrl, [
            'headers' => $headers,
            'json' => $requestData,
        ]);

        $statusCode = $response->getStatusCode();
        $responseBody = $response->getBody()->getContents();

        return response()->json([
            'status_code' => $statusCode,
            'response' => json_decode($responseBody),
        ]);
    }

    public function createCustomer(Request $request)
    {

        $clientId = 'AUsKUKqQ8P7j12NkJuI3Z0JThbso6P9c4TuvbSwmWkEbqkloxGJsAJ9h8meV_I5q7ZlcXPyma-1yD2Tg';
        $clientSecret = 'EL6IWKl5d7NFfZWdigPJtzQ_5mjj1t74koBHTeimA-RVAOo0df5WXk3LlQPT8zI45ZRQpXeA3Ert251D';

        // Set up the API context with your credentials
        $apiContext = new ApiContext(new OAuthTokenCredential($clientId, $clientSecret));
        $apiContext->setConfig([
            'mode' => 'sandbox', // 'sandbox' for testing, 'live' for production
        ]);

        // Create a new Payer object with payment method 'paypal'
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        // Create a new Payment object and set the payer and redirect URLs
        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer);

        // Create a new CreditCard object with card details
        $card = new CreditCard();
        $card->setType($request->input('card_type'))
             ->setNumber($request->input('card_number'))
             ->setExpireMonth($request->input('card_exp_month'))
             ->setExpireYear($request->input('card_exp_year'))
             ->setCvv2($request->input('card_cvv2'))
             ->setFirstName($request->input('first_name'))
             ->setLastName($request->input('last_name'));

        // Add the credit card to the payment object as the funding instrument
        // $fundingInstrument = new FundingInstrument();
        // $fundingInstrument->setCreditCard($card);

        // $payer->setFundingInstruments([$fundingInstrument]);
        $payer->setFundingInstruments(array($card));

        try {
            // Create the payment and get the approval link
            $payment->create($apiContext);
            $approvalLink = $payment->getApprovalLink();

            return response()->json(['approval_link' => $approvalLink]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


        // $apiUrl = $this->apiEndpoint . '/v1/billing/customers';

        // $headers = [
        //     'Authorization' => 'Bearer ' . $this->getAccessToken(),
        //     'Content-Type' => 'application/json',
        // ];

        // $requestData = [
        //     'email_address' => $request->input('email'),
        //     'name' => [
        //         'given_name' => $request->input('first_name'),
        //         'surname' => $request->input('last_name'),
        //     ],
        //     // Add other customer details as needed
        // ];

        // $client = new Client();
        // $response = $client->post($apiUrl, [
        //     'headers' => $headers,
        //     'json' => $requestData,
        // ]);

        // $statusCode = $response->getStatusCode();
        // $responseBody = $response->getBody()->getContents();
        // $customerData = json_decode($responseBody, true);

        // return response()->json([
        //     'status_code' => $statusCode,
        //     'customer' => $customerData,
        // ]);
    }

    public function createAuthorization(Request $request)
    {
        $apiUrl = $this->apiEndpoint . '/' . $this->apiVersion . '/payments/authorizations';

        $headers = [
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
            'Content-Type' => 'application/json',
        ];

        $requestData = [
            'intent' => 'AUTHORIZE',
            'payer' => [
                'payment_method' => 'paypal',
            ],
            'transactions' => [
                [
                    'amount' => [
                        'total' => '10.00', // Replace with the amount you want to authorize
                        'currency' => 'USD', // Replace with the desired currency
                    ],
                ],
            ],
            'redirect_urls' => [
                'return_url' => 'https://example.com/success', // Replace with your success URL
                'cancel_url' => 'https://example.com/cancel', // Replace with your cancel URL
            ],
        ];

        $client = new Client();
        $response = $client->post($apiUrl, [
            'headers' => $headers,
            'json' => $requestData,
        ]);

        $statusCode = $response->getStatusCode();
        $responseBody = $response->getBody()->getContents();
        $authorizationData = json_decode($responseBody, true);

        return response()->json([
            'status_code' => $statusCode,
            'authorization' => $authorizationData,
        ]);
    }

    function getAllCustomersFromPayPal()
    {
        // Replace these variables with your actual PayPal API credentials
        $clientId = 'AUsKUKqQ8P7j12NkJuI3Z0JThbso6P9c4TuvbSwmWkEbqkloxGJsAJ9h8meV_I5q7ZlcXPyma-1yD2Tg';
        $clientSecret = 'EL6IWKl5d7NFfZWdigPJtzQ_5mjj1t74koBHTeimA-RVAOo0df5WXk3LlQPT8zI45ZRQpXeA3Ert251D';

        // Base64 encode the credentials for API authentication
        $apiContext = new ApiContext(
            new OAuthTokenCredential($clientId, $clientSecret)
        );
        $apiContext->setConfig([
            'mode' => 'sandbox', // Change to 'live' for production environment
        ]);
    
        // Search for billing agreements to get all customers (payers)
        // try {
            $params = [
                'status' => 'ACTIVE',
                'page_size' => 100, // Set the number of agreements to retrieve in one call
            ];
            $agreementSearch = new AgreementSearch();
            $agreementSearch->setParameters($params);
    
            $agreements = Agreement::search($agreementSearch, $apiContext);
            dd($agreements);
    
            // Extract the customer (payer) information from the agreements
            $customers = [];
            foreach ($agreements->getAgreements() as $agreement) {
                $customerInfo = [
                    'agreement_id' => $agreement->getId(),
                    'customer_name' => $agreement->getPayer()->getPayerInfo()->getFirstName(),
                    'customer_email' => $agreement->getPayer()->getPayerInfo()->getEmail(),
                    // Add any other relevant customer information fields here
                ];
                $customers[] = $customerInfo;
            }
    
            return $customers;
        // } catch (Exception $e) {
        //     // Handle any exceptions that might occur during the API request
        //     return null;
        // }
        
    }


    /* start using Api endpoint */
    public function createPayment(Request $request)
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item1 = new Item();
        $item1->setName('Ground Coffee 40 oz')
            ->setCurrency('USD')
            ->setQuantity(1)
            // ->setSku("123123") // Similar to `item_number` in Classic API
            ->setPrice(46);


        $item_list = new ItemList();
        $item_list->setItems(array($item1));


        // $details = new Details();
        // $details->setShipping(1.2)
        //     ->setTax(1.3)
        //     ->setSubtotal(17.50);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal(46);
            // ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.execute'))
                        ->setCancelUrl(route('paypal.cancel'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));       
        // dd($payment);     
        try {
            $payment->create($apiContext);

        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                return Redirect::route('paywithpaypal');                
            } else {
                return Redirect::route('paywithpaypal');                
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                return response()->json(['approval_url' => $redirect_url]);
            }
        }
        dd('sadf');
  
        $token = $this->getAccessToken();
        if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal.'], 500);
        }
        $payer = [
            'payment_method' => 'paypal',
        ];
        $amount = [
            'total' => '125',
            'currency' => 'USD', // Change this if you're using a different currency
        ];
        $transaction = [
            'amount' => $amount,
        ];
        $redirectUrls = [
            'return_url' => route('paypal.execute'),
            'cancel_url' => route('paypal.cancel'),
        ];
        $payment = [
            'intent' => 'sale',
            'payer' => $payer,
            'transactions' => [$transaction],
            'redirect_urls' => $redirectUrls,
        ];

        $response = Http::withToken($token)->post($this->apiBaseUrl.'/v1/payments/payment', $payment);

        if ($response->failed()) {
            return response()->json(['error' => 'Payment could not be processed. Please try again later.'], 500);
        }

        $approvalUrl = collect($response->json('links'))->firstWhere('rel', 'approval_url')['href'];

        return response()->json(['approval_url' => $approvalUrl]);
    }

    public function executePayment(Request $request)
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );
        
        // http://127.0.0.1:8000/api/execute-payment?paymentId=PAYID-MTD4KAY6RB187934A670431J&token=EC-90L181868A999481S&PayerID=GFTZCP5KDQ2KC
        $token = $this->getAccessToken();

        if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal.'], 500);
        }
        
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        // dd($request->all());
        $payment = Payment::get($paymentId, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        $result = $payment->execute($execution, $apiContext);
        // $response =  json_decode($result);
        // dd($payment->id, $payment->state, $payment->payer->payer_info->payer_id, $payment->transactions[0]->amount->total);

        $user_id = $request->user_id;
        $email = $request->email;

        $user_type = "";
        if(isset($user_id)){
            $user_type = "register";
        }else{
            $user_type = "guest";
        }

        $paymentprofile                     = new PaymentProfile;
        $paymentprofile->user_type          = $user_type;
        $paymentprofile->user_id            = $user_id;
        $paymentprofile->profile_id         = $payment->payer->payer_info->payer_id;
        $paymentprofile->payment_id         = $payment->id;
        $paymentprofile->pay_amount         = $payment->transactions[0]->amount->total;
        $paymentprofile->save();


        
        dd($paymentprofile);

 
        // // Extract credit card details from the PayPal API response
        // $cardDetails = $result->payer->funding_instruments[0]->credit_card;
        // dd($cardDetails);

        // $execution = [
        //     'payer_id' => $payerId,
        // ];

        // return response()->json(['success' => 'Payment successful! Thank you for your purchase.']);
        $response = Http::withToken($token)->post($this->apiBaseUrl."/v1/payments/payment/{$paymentId}/execute", $execution);

        if ($response->failed()) {
            return response()->json(['error' => 'Payment could not be processed. Please try again later.'], 500);
        }

        dd('sadf');


        $paymentResponse = $response->json();
        // Extract relevant data from the PayPal API response
        $transactionId = $paymentResponse['id']; // Transaction ID
        dd($transactionId);
        $amount = $paymentResponse['transactions'][0]['amount']['total']; // Payment amount
        $currency = $paymentResponse['transactions'][0]['amount']['currency']; // Currency

        // $cardDetails = $paymentResponse['payer']['funding_instruments'][0]['credit_card']; // Credit card details
        // $paymentMethod = $paymentResponse['payer']['payer_info']['payment_method'];
        // // If the payment method is 'credit_card', you can access additional credit card details
        // if ($paymentMethod === 'credit_card') {
        //     $creditCardType = $paymentResponse['payer']['payer_info']['credit_card']['type'];
        //     $creditCardLastFour = $paymentResponse['payer']['payer_info']['credit_card']['number'];
            
        //     // Store $creditCardType and $creditCardLastFour in your database or perform further processing
        // }
        // The payer's email address can also be accessed
        // $payerEmail = $paymentResponse['payer']['payer_info']['email'];
        
        // dd($payerEmail);

        // Payment completed successfully, you can process the payment details here
        return response()->json(['success' => 'Payment successful! Thank you for your purchase.']);
    }

    

    public function cancelPayment()
    {
        // Handle the case when the user cancels the payment
        return response()->json(['error' => 'Payment cancelled.'], 500);
    }
    /* end using Api endpoint */


    public function createAgreement(Request $request)
    {
        // $apiContext = new \PayPal\Rest\ApiContext(
        //     new \PayPal\Auth\OAuthTokenCredential(
        //         config('paypal.client_id'),
        //         config('paypal.secret')
        //     )
        // );
        // try {
        // $agreement = new Agreement();

        // $agreement->setName('Base Agreement')
        //     ->setDescription('Basic Agreement')
        //     ->setStartDate('2019-06-17T9:45:04Z');

        // $plan = new Plan();
        // $plan->setId('P-006734860J891803LTQIDJLA');
        // $agreement->setPlan($plan);

        // $payer = new Payer();
        // $payer->setPaymentMethod('paypal');
        // $agreement->setPayer($payer);
        
        // $shippingAddress = new ShippingAddress();
        // $shippingAddress->setLine1('111 First Street')
        // ->setCity('Saratoga')
        // ->setState('CA')
        // ->setPostalCode('95070')
        // ->setCountryCode('US');
        // $agreement->setShippingAddress($shippingAddress);
        
        // $request = clone $agreement;
        // $agreement = $agreement->create($apiContext);
 
        // } catch (\Exception $e) {
        //     \Log::error('PayPal Error: ' . $e->getMessage());
        //     return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
        // }


        // dd('avobe code fro php doc');
        

        // $agreement = new Agreement();
        // $agreement->setName('Subscription Name')
        //     ->setDescription('Monthly Subscription')
        //     ->setStartDate(date('Y-m-d\TH:i:s\Z', strtotime('+1 day')));

        // // Set plan ID obtained from PayPal
        // $planId = 'P-006734860J891803LTQIDJLA'; // Replace with your plan ID
        // $agreement->setPlan($planId);
        // $createdAgreement = $agreement->create($apiContext);
        // // dd($createdAgreement);

        // $approvalLink = $createdAgreement->getApprovalLink();
        // dd($approvalLink);

        // // Create agreement
        // try {
            
        //     return response()->json(['approval_url' => $approvalUrl]);
        // } catch (PayPalConnectionException $e) {
        //     return response()->json(['error' => 'PayPal Connection Error: ' . $e->getMessage()], 500);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Error creating subscription: ' . $e->getMessage()], 500);
        // }
        // dd('upar chatGpt');

        
        $token = $this->getAccessToken();
        $planId = $request->input('plan_id');
        $payerEmail = $request->input('payer_email');
        $payerName = $request->input('payer_name');

        if (!$token) {
            return null;
        }

        $agreement = [
            'name' => 'Recurring Agreement',
            'description' => 'Recurring payment agreement based on billing plan',
            'start_date' => date('Y-m-d\TH:i:s\Z', strtotime('now + 1 day')), // Starting tomorrow
            'plan' => [
                'id' => $planId,
            ],
            'payer' => [
                'email' => $payerEmail,
                'name' => $payerName,
                'payment_method' => 'paypal',

            ],
        ];
      

        $response = Http::withToken($token)->post($this->apiBaseUrl.'/v1/payments/billing-agreements', $agreement);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to create the billing agreement.'], 500);
        }

        $approvalUrl = collect($response->json('links'))->firstWhere('rel', 'approval_url');

        if (!$approvalUrl) {
            return response()->json(['error' => 'Approval URL not found in the response.'], 500);
        }

        $approvalUrl = $approvalUrl['href'];

        return response()->json(['approval_url' => $approvalUrl]);
    }


    public function executeAgreement(Request $request)
    {
        $token = $this->getAccessToken();
        dd($token, 'et');
               if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal.'], 500);
        }

        $token = $request->input('token');

        $response = Http::withToken($token)->post($this->apiBaseUrl."/v1/payments/billing-agreements/{$token}/agreement-execute");

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to execute the billing agreement.'], 500);
        }

        // Recurring payment agreement executed successfully
        return response()->json(['success' => 'Recurring payment agreement executed successfully.']);
    }


    public function activatePlan(Request $request)
    {
        $planId = $request->input('plan_id');

        $token = $this->getAccessToken();

        if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal.'], 500);
        }

        $url = $this->apiBaseUrl . '/v1/payments/billing-plans/' . $planId . '/activate';

        $response = Http::withToken($token)->post($url);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to activate the billing plan.', 'error_details' => $response->json()], 500);
        }

        return response()->json(['message' => 'Billing plan activated successfully.']);



        $token = $this->getAccessToken();

        if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal.'], 500);
        }

        // Get the current state of the billing plan
        $response = Http::withToken($token)->get($this->apiBaseUrl.'/v1/payments/billing-plans/'.$planId);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to retrieve billing plan details.', 'error_details' => $response->json()], 500);
        }

        $planState = $response->json('state');

        // Check if the plan is already in an active state
        if ($planState === 'ACTIVE') {
            return response()->json(['message' => 'Billing plan is already in an active state.']);
        }

        // Attempt to activate the billing plan using POST method
        $url = $this->apiBaseUrl.'/v1/payments/billing-plans/'.$planId.'/activate';
        $response = Http::withToken($token)->post($url);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to activate the billing plan.', 'error_details' => $response->json()], 500);
        }

        return response()->json(['message' => 'Billing plan activated successfully.']);
    }


    public function return(Request $request){
        dd($request);
    }
    public function cancel(Request $request){
        dd($request);
    }
    
    /**
     * autoPaymentPAypal
     *
     * @param  mixed $request
     * @return void
     */
    public function autoPaymentPaypal(Request $request)
    {

        $req = 'cmd=_notify-validate';
    
        // Read the post from PayPal
        foreach ($request as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
    
        /* i'm using sandbox for demo change it with live */
        $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    
    
        // Now Post all of that back to PayPal's server using curl, and validate everything with PayPal
        // We will use CURL instead of PHP for this for a more universally operable script (fsockopen has issues on some environments)
        //$url = "https://www.sandbox.paypal.com/cgi-bin/webscr"; //USE SANDBOX ACCOUNT TO TEST WITH
        //$url = "https://www.paypal.com/cgi-bin/webscr"; //LIVE ACCOUNT
    
        $curl_result=$curl_err='';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$paypalURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
        curl_setopt($ch, CURLOPT_HEADER , 0);   
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $curl_result = @curl_exec($ch);
        $curl_err = curl_error($ch);
        curl_close($ch);
    
        $req = str_replace("&", "\n", $req);  // Make it a nice list in case we want to email it to ourselves for reporting
    
        // Check that the result verifies with PayPal
        if (strpos($curl_result, "VERIFIED") !== false) {
            $req .= "\n\nPaypal Verified OK";
        } else {
            $req .= "\n\nData NOT verified from Paypal!";
            //mail("email@gmail.com", "IPN interaction not verified", "$req", "From: email@gmail.com" );
            exit();
        }
    
    
        if (array_key_exists("txn_id", $_POST)) {
    
            /* all response for future use conver it into json format */
            $payment_rawData = json_encode($_POST);
    
            $item_number = $_POST['item_number'];
            $txn_id = $_POST['txn_id'];
            $amount = $_POST['mc_gross'];
            $currency_code = $_POST['mc_currency'];
            $custom = $_POST['custom'];
            $payment_status = $_POST['payment_status'];
    
            //Insert tansaction data into the database
            $payment_info = array('payment_userId'=>$custom,'payment_planId'=>$item_number,'payment_txnId'=>$txn_id,'payment_amount'=>$amount,'payment_currency'=>$currency_code,'payment_status'=> $payment_status,'payment_rawData'=>$payment_rawData,'createdDate'=>date('Y-m-d H:i:s'),'updatedDate'=>date('Y-m-d H:i:s'));
    
            $this->paypal_model->insertTransaction($payment_info);
        }
    }
    
    




    

}
