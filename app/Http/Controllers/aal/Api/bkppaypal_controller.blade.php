<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\CreditCard;
use PayPal\Api\Customer;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementSearch;

use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;

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
        $tokenEndpoint = $this->apiEndpoint . '/v1/oauth2/token';
        // dd($tokenEndpoint);

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
                    $this->clientId,
                    $this->clientSecret,
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
        $clientId = 'AUsKUKqQ8P7j12NkJuI3Z0JThbso6P9c4TuvbSwmWkEbqkloxGJsAJ9h8meV_I5q7ZlcXPyma-1yD2Tg';
        $clientSecret = 'EL6IWKl5d7NFfZWdigPJtzQ_5mjj1t74koBHTeimA-RVAOo0df5WXk3LlQPT8zI45ZRQpXeA3Ert251D';
  
        $apiContext = new ApiContext(new OAuthTokenCredential($clientId, $clientSecret));
        $apiContext->setConfig([
            'mode' => 'sandbox', // 'sandbox' for testing, 'live' for production
        ]);

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
        
        try {
            // Make the API call to list credit cards associated with the payer
            $cards = CreditCard::all(['payer_id' => $request->input('payer_id')], $apiContext);

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


    /* start using inbuild package*/
    // public function createPayment(Request $request)
    // {
    //     $apiContext = new \PayPal\Rest\ApiContext(
    //         new \PayPal\Auth\OAuthTokenCredential(
    //             config('paypal.client_id'),
    //             config('paypal.secret')
    //         )
    //     );

    //     $payer = new Payer();
    //     $payer->setPaymentMethod('paypal');

    //     $amount = new Amount();
    //     $amount->setTotal('124');
    //     $amount->setCurrency('USD'); // Change this if you're using a different currency

    //     $transaction = new Transaction();
    //     $transaction->setAmount($amount);

    //     $redirectUrls = new RedirectUrls();
    //     $redirectUrls->setReturnUrl(route('paypal.execute'))
    //         ->setCancelUrl(route('paypal.cancel'));

    //     $payment = new Payment();
    //     $payment->setIntent('sale')
    //         ->setPayer($payer)
    //         ->setTransactions([$transaction])
    //         ->setRedirectUrls($redirectUrls);

    //         try {
    //              $payment->create($apiContext);
    //             // dd($pay1);
                
    //     } catch (\PayPal\Exception\PayPalConnectionException $e) {
    //         // Handle any exceptions that might occur during API call
    //         // e.g., $e->getCode(), $e->getData()
    //         return response()->json(['error' => 'Payment could not be processed. Please try again later.'], 500);
    //     }

    //     $approvalUrl = $payment->getApprovalLink();
    //     return response()->json(['approval_url' => $approvalUrl]);
    // }

    // public function executePayment(Request $request)
    // {
    //     $apiContext = new \PayPal\Rest\ApiContext(
    //         new \PayPal\Auth\OAuthTokenCredential(
    //             config('paypal.client_id'),
    //             config('paypal.secret')
    //         )
    //     );

    //     $paymentId = $request->input('paymentId');
    //     $payerId = $request->input('PayerID');

    //     $payment = Payment::get($paymentId, $apiContext);

    //     $execution = new PaymentExecution();
    //     $execution->setPayerId($payerId);
 
    //     try {
    //         $result = $payment->execute($execution, $apiContext);
    //     } catch (\PayPal\Exception\PayPalConnectionException $e) {
    //         // Handle any exceptions that might occur during API call
    //         // e.g., $e->getCode(), $e->getData()
    //         return response()->json(['error' => 'Payment could not be processed. Please try again later.'], 500);
    //     }

    //     // Payment completed successfully, you can process the payment details here
    //     return response()->json(['success' => 'Payment successful! Thank you for your purchase.']);
    // }

    // public function cancelPayment()
    // {
    //     // Handle the case when the user cancels the payment
    //     return response()->json(['error' => 'Payment cancelled.'], 500);
    // }
    /* end using inbuild package*/

    public function createPayment(Request $request)
    {
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
        $token = $this->getAccessToken();

        if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal.'], 500);
        }

        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');

        $execution = [
            'payer_id' => $payerId,
        ];

        $response = Http::withToken($token)->post($this->apiBaseUrl."/v1/payments/payment/{$paymentId}/execute", $execution);

        if ($response->failed()) {
            return response()->json(['error' => 'Payment could not be processed. Please try again later.'], 500);
        }

        // Payment completed successfully, you can process the payment details here
        return response()->json(['success' => 'Payment successful! Thank you for your purchase.']);
    }

    private function getAccessToken1()
    {
        $clientId = config('paypal.client_id');
        $secret = config('paypal.secret');
        $credentials = base64_encode("{$clientId}:{$secret}");
        

        $response = Http::post($this->apiBaseUrl.'/v1/oauth2/token', [
            'headers' => [
                'Authorization' => 'Basic '.$credentials,
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);
        dd($response->json('access_token'));

        if ($response->failed()) {
            return null;
        }

        return $response->json('access_token');
    }

    public function cancelPayment()
    {
        // Handle the case when the user cancels the payment
        return response()->json(['error' => 'Payment cancelled.'], 500);
    }





    

}
