<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Config;
use App\Models\User;

class AddCardController extends Controller
{
    public function addCard(Request $request)
    {
        dd(Config::get('app.AUTHORIZENET_API_LOGIN_ID'));
        // Set your Authorize.Net API credentials
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(Config::get('app.AUTHORIZENET_API_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(Config::get('app.AUTHORIZENET_TRANSACTION_KEY'));

        $customerProfileId = $request->input('customerProfileId');

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($request->input('cardNumber'));
        $creditCard->setExpirationDate($request->input('expirationDate'));
        $paymentCreditCard = new AnetAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        $customerPaymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $customerPaymentProfile->setCustomerType('individual');
        $customerPaymentProfile->setPayment($paymentCreditCard);

        $paymentProfiles[] = $customerPaymentProfile;

        $customerProfile = new AnetAPI\CustomerProfileType();
        $customerProfile->setMerchantCustomerId('123'); // Set a unique identifier for the customer
        $customerProfile->setDescription('Customer description');
        $customerProfile->setEmail($request->input('email'));
        $customerProfile->setPaymentProfiles($paymentProfiles);

        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setProfile($customerProfile);

        $controller = new AnetController\CreateCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            $customerProfileId = $response->getCustomerProfileId();

            return response()->json(['customerProfileId' => $customerProfileId]);
        } else {
            $errorMessages = $response->getMessages()->getMessage();
            $errorText = "Error adding card: ";

            foreach ($errorMessages as $errorMessage) {
                $errorText .= $errorMessage->getCode() . " " . $errorMessage->getText() . "\n";
            }

            return response()->json($errorText, 500);
        }
    }

    

    public function addUser(Request $request)
    {
        // dd($request); 
        // Set your Authorize.Net API credentials
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(Config::get('app.AUTHORIZENET_API_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(Config::get('app.AUTHORIZENET_TRANSACTION_KEY'));

        // Retrieve or create the user based on the email
        $user = User::firstOrCreate(['email' => $request->input('email')]);

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($request->input('cardNumber'));
        $creditCard->setExpirationDate($request->input('expirationDate'));
        $creditCard->setCardCode($request->input('cvv')); // Set the CVV

        $paymentCreditCard = new AnetAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        $customerPaymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $customerPaymentProfile->setCustomerType('individual');
        $customerPaymentProfile->setPayment($paymentCreditCard);

        $paymentProfiles[] = $customerPaymentProfile;

        $customerProfile = new AnetAPI\CustomerProfileType();
        $customerProfile->setMerchantCustomerId($user->id); // Set a unique identifier for the customer
        $customerProfile->setDescription('Customer description');
        $customerProfile->setEmail($request->input('email'));
        $customerProfile->setPaymentProfiles($paymentProfiles);

        // Create the user in your application or update any necessary user details
        // $user->update(['card_number' => $request->input('cardNumber'), 'expiration_date' => $request->input('expirationDate')]);

        return response()->json(['message' => 'Card added successfully']);
    }


    // use App\Models\User;

    public function addCard1(Request $request)
    {
        // Set your Authorize.Net API credentials
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName('YOUR_API_LOGIN_ID');
        $merchantAuthentication->setTransactionKey('YOUR_TRANSACTION_KEY');

        // Retrieve or create the user based on the email
        $user = User::firstOrCreate(['email' => $request->input('email')]);

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($request->input('cardNumber'));
        $creditCard->setExpirationDate($request->input('expirationDate'));
        $paymentCreditCard = new AnetAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        $customerPaymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $customerPaymentProfile->setCustomerType('individual');
        $customerPaymentProfile->setPayment($paymentCreditCard);

        $paymentProfiles[] = $customerPaymentProfile;

        $customerProfile = new AnetAPI\CustomerProfileType();
        $customerProfile->setMerchantCustomerId($user->id); // Set a unique identifier for the customer
        $customerProfile->setDescription('Customer description');
        $customerProfile->setEmail($request->input('email'));
        $customerProfile->setPaymentProfiles($paymentProfiles);

        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setProfile($customerProfile);

        $controller = new AnetController\CreateCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            $customerProfileId = $response->getCustomerProfileId();

            return response()->json(['customerProfileId' => $customerProfileId]);
        } else {
            $errorMessages = $response->getMessages()->getMessage();
            $errorText = "Error adding card: ";

            foreach ($errorMessages as $errorMessage) {
                $errorText .= $errorMessage->getCode() . " " . $errorMessage->getText() . "\n";
            }

            return response()->json($errorText, 500);
        }
    }


    public function addCard2(Request $request)
    {
        // Set your Authorize.Net API credentials
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName('YOUR_API_LOGIN_ID');
        $merchantAuthentication->setTransactionKey('YOUR_TRANSACTION_KEY');

        // Retrieve or create the user based on the email
        $user = User::firstOrCreate(['email' => $request->input('email')]);

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($request->input('cardNumber'));
        $creditCard->setExpirationDate($request->input('expirationDate'));
        $creditCard->setCardCode($request->input('cvv')); // Set the CVV

        $paymentCreditCard = new AnetAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        $customerPaymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $customerPaymentProfile->setCustomerType('individual');
        $customerPaymentProfile->setPayment($paymentCreditCard);

        $paymentProfiles[] = $customerPaymentProfile;

        $customerProfile = new AnetAPI\CustomerProfileType();
        $customerProfile->setMerchantCustomerId($user->id); // Set a unique identifier for the customer
        $customerProfile->setDescription('Customer description');
        $customerProfile->setEmail($request->input('email'));
        $customerProfile->setPaymentProfiles($paymentProfiles);

        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setProfile($customerProfile);

        $controller = new AnetController\CreateCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            $customerProfileId = $response->getCustomerProfileId();

            return response()->json(['customerProfileId' => $customerProfileId]);
        } else {
            $errorMessages = $response->getMessages()->getMessage();
            $errorText = "Error adding card: ";

            foreach ($errorMessages as $errorMessage) {
                $errorText .= $errorMessage->getCode() . " " . $errorMessage->getText() . "\n";
            }

            return response()->json($errorText, 500);
        }
    }


}
