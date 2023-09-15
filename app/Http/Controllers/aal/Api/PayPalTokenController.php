<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PayPalTokenController extends Controller
{
    public function getAccessToken(){
        $tokenEndpoint = config('paypal.end_point') . '/'.config('paypal.version').'/oauth2/token';
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

    public function getApiContext(){
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );
        return $apiContext;
    }
}
