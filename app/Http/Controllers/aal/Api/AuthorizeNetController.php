<?php

namespace App\Http\Controllers\Api;

use net\authorize\api\controller as AnetController;
use net\authorize\api\contract\v1 as AnetAPI;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\CardDetail;
use Config;

class AuthorizeNetController extends Controller
{

    /*
    * Merchant Authentication
    */
    function getMerchantAuthentication(){
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(Config::get('app.AUTHORIZENET_API_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(Config::get('app.AUTHORIZENET_TRANSACTION_KEY'));
        return $merchantAuthentication;
    }


    public function processPayment(Request $request)
    {
        dd('asfd');        
    }

    public function createCustomer(Request $request){
        
        $user_id = $request->user_id;
        $email = $request->email;
        $cardNumber = $request->cardNumber;
        $expirationDate = $request->expirationDate;

        $user_type = "";
        if(isset($user_id)){
            $user_type = "register";
        }else{
            $user_type = "guest";
        }

        $merchantAuthentication = $this->getMerchantAuthentication();
        
        // Set the transaction's refId
        $refId = 'ref' . time();

        // Set credit card information for payment profile
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($expirationDate);
        $creditCard->setCardCode("142");
        $paymentCreditCard = new AnetAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        // Create the Bill To info for new payment type

        // $billTo = new AnetAPI\CustomerAddressType();
        // $billTo->setFirstName("Ellen");
        // $billTo->setLastName("Johnson");
        // $billTo->setCompany("Souveniropolis");
        // $billTo->setAddress("14 Main Street");
        // $billTo->setCity("Pecan Springs");
        // $billTo->setState("TX");
        // $billTo->setZip("44628");
        // $billTo->setCountry("USA");
        // $billTo->setPhoneNumber("888-888-8888");
        // $billTo->setfaxNumber("999-999-9999");

        // Create a customer shipping address
        // $customerShippingAddress = new AnetAPI\CustomerAddressType();
        // $customerShippingAddress->setFirstName("James");
        // $customerShippingAddress->setLastName("White");
        // $customerShippingAddress->setCompany("Addresses R Us");
        // $customerShippingAddress->setAddress(rand() . " North Spring Street");
        // $customerShippingAddress->setCity("Toms River");
        // $customerShippingAddress->setState("NJ");
        // $customerShippingAddress->setZip("08753");
        // $customerShippingAddress->setCountry("USA");
        // $customerShippingAddress->setPhoneNumber("888-888-8888");
        // $customerShippingAddress->setFaxNumber("999-999-9999");

        // // Create an array of any shipping addresses
        // $shippingProfiles[] = $customerShippingAddress;


        // Create a new CustomerPaymentProfile object
        $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $paymentProfile->setCustomerType('individual');
        // $paymentProfile->setBillTo($billTo);
        $paymentProfile->setPayment($paymentCreditCard);
        $paymentProfiles[] = $paymentProfile;


        // Create a new CustomerProfileType and add the payment profile object
        $customerProfile = new AnetAPI\CustomerProfileType();
        $customerProfile->setDescription("Customer 2 Test PHP");
        $customerProfile->setMerchantCustomerId("M_" . time());
        $customerProfile->setEmail($email);
        $customerProfile->setpaymentProfiles($paymentProfiles);
        // $customerProfile->setShipToList($shippingProfiles);


        // Assemble the complete transaction request
        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setProfile($customerProfile);

        // Create the controller and get the response
        $controller = new AnetController\CreateCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        // dd($response->getCustomerProfileId());
        $customerProfileId = $response->getCustomerProfileId();

        // for card detils
        $request = new AnetAPI\GetCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setCustomerProfileId($customerProfileId);

        $controller = new AnetController\GetCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {

            $profileSelected = $response->getProfile();
            $paymentProfilesSelected = $profileSelected->getPaymentProfiles();

            foreach ($paymentProfilesSelected as $paymentProfile) {
                $paymentProfileId = $paymentProfile->getCustomerPaymentProfileId();  //Payment Profile ID
                $paymentProfileType = $paymentProfile->getPayment()->getCreditCard()->getCardType(); //Card Type
                $paymentProfileNumber = $paymentProfile->getPayment()->getCreditCard()->getCardNumber(); //Card Number
                $expirationDate = $paymentProfile->getPayment()->getCreditCard()->getExpirationDate();
                $expiryMonth = substr($expirationDate, 5, 2); //Expiry Month
                $expiryYear = substr($expirationDate, 0, 4); //Expiry Year

                $billTo = $paymentProfile->getBillTo();
                $cardholderName = ($billTo != null) ? $billTo->getFirstName() . ' ' . $billTo->getLastName() : 'N/A';  //Cardholder Name
            }
        }

        // To save the data in mysql
        $paymentprofile                     = new CardDetail;
        $paymentprofile->user_type          = $user_type;
        $paymentprofile->user_id            = $user_id;
        $paymentprofile->profile_id         = $customerProfileId;       
        $paymentprofile->card_id            = $paymentProfileId;
        $paymentprofile->card_type          = $paymentProfileType;
        $paymentprofile->card_number        = $paymentProfileNumber;
        $paymentprofile->expiry_month       = $expiryMonth;
        $paymentprofile->expiry_year        = $expiryYear;
        $paymentprofile->cardholder_name    = $cardholderName;
        $paymentprofile->save();
        // dd($paymentprofile);
  
        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            echo "Succesfully created customer profile : " . $customerProfileId . "\n";
            // $paymentProfiles = $response->getCustomerPaymentProfileIdList();
            // echo "SUCCESS: PAYMENT PROFILE ID : " . $paymentProfiles[0] . "\n";
        } else {
            echo "ERROR :  Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
        }
        return $response;
    }

    public function storebkp(Request $request){       
        $merchantAuthentication = $this->getMerchantAuthentication();
        
        $refId = 'ref' . time();

        // Create a Customer Profile Request
        //  1. (Optionally) create a Payment Profile
        //  2. (Optionally) create a Shipping Profile
        //  3. Create a Customer Profile (or specify an existing profile)
        //  4. Submit a CreateCustomerProfile Request
        //  5. Validate Profile ID returned

        // Set credit card information for payment profile
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber("4242424242424242");
        $creditCard->setExpirationDate("2038-12");
        $creditCard->setCardCode("142");
        $paymentCreditCard = new AnetAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        // Create the Bill To info for new payment type
        $billTo = new AnetAPI\CustomerAddressType();
        $billTo->setFirstName("Ellen");
        $billTo->setLastName("Johnson");
        $billTo->setCompany("Souveniropolis");
        $billTo->setAddress("14 Main Street");
        $billTo->setCity("Pecan Springs");
        $billTo->setState("TX");
        $billTo->setZip("44628");
        $billTo->setCountry("USA");
        $billTo->setPhoneNumber("888-888-8888");
        $billTo->setfaxNumber("999-999-9999");

        // Create a customer shipping address
        $customerShippingAddress = new AnetAPI\CustomerAddressType();
        $customerShippingAddress->setFirstName("James");
        $customerShippingAddress->setLastName("White");
        $customerShippingAddress->setCompany("Addresses R Us");
        $customerShippingAddress->setAddress(rand() . " North Spring Street");
        $customerShippingAddress->setCity("Toms River");
        $customerShippingAddress->setState("NJ");
        $customerShippingAddress->setZip("08753");
        $customerShippingAddress->setCountry("USA");
        $customerShippingAddress->setPhoneNumber("888-888-8888");
        $customerShippingAddress->setFaxNumber("999-999-9999");

        // Create an array of any shipping addresses
        $shippingProfiles[] = $customerShippingAddress;


        // Create a new CustomerPaymentProfile object
        $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $paymentProfile->setCustomerType('individual');
        $paymentProfile->setBillTo($billTo);
        $paymentProfile->setPayment($paymentCreditCard);
        $paymentProfiles[] = $paymentProfile;


        // Create a new CustomerProfileType and add the payment profile object
        $customerProfile = new AnetAPI\CustomerProfileType();
        $customerProfile->setDescription("Customer 2 Test PHP");
        $customerProfile->setMerchantCustomerId("M_" . time());
        $customerProfile->setEmail("test123@test.com");
        $customerProfile->setpaymentProfiles($paymentProfiles);
        $customerProfile->setShipToList($shippingProfiles);


        // Assemble the complete transaction request
        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setProfile($customerProfile);

        // Create the controller and get the response
        $controller = new AnetController\CreateCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
    
        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            echo "Succesfully created customer profile : " . $response->getCustomerProfileId() . "\n";
            $paymentProfiles = $response->getCustomerPaymentProfileIdList();
            echo "SUCCESS: PAYMENT PROFILE ID : " . $paymentProfiles[0] . "\n";
        } else {
            echo "ERROR :  Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
        }
        return $response;
    }


    public function addCard(Request $request){
        $proifileId = $request->customer_profile_id;

        // dd($request->customer_profile_id);
        $merchantAuthentication = $this->getMerchantAuthentication();

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($request->card_number);
        $creditCard->setExpirationDate($request->expir_date);
        $paymentCreditCard = new AnetAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $paymentProfile->setCustomerType('individual');
        $paymentProfile->setPayment($paymentCreditCard);

        // Create a new PaymentProfile object
        $paymentProfiles = array($paymentProfile);

        $request = new AnetAPI\CreateCustomerPaymentProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setCustomerProfileId($proifileId);
        $request->setPaymentProfile($paymentProfile);

        // Create the controller and get the response
        $controller = new AnetController\CreateCustomerPaymentProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            echo "Successfully saved payment data for customer profile ID: " . $response->getCustomerProfileId() . "\n";
            echo "Payment Profile ID: " . $response->getCustomerPaymentProfileId() . "\n";
        } else {
            echo "Error: Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            echo "Response: " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";
        }
        return $response;
        
    }

    public function listCard(Request $request){
        
        $merchantAuthentication = $this->getMerchantAuthentication();

        // Retrieve an existing customer profile along with all the associated payment profiles and shipping addresses
        $request = new AnetAPI\GetCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setCustomerProfileId("912963794");

        $controller = new AnetController\GetCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            $paymentProfilesData = array();

            $profileSelected = $response->getProfile();
            $paymentProfilesSelected = $profileSelected->getPaymentProfiles();

            foreach ($paymentProfilesSelected as $paymentProfile) {
                $paymentProfileId = $paymentProfile->getCustomerPaymentProfileId();
                $paymentProfileType = $paymentProfile->getPayment()->getCreditCard()->getCardType();
                $paymentProfileNumber = $paymentProfile->getPayment()->getCreditCard()->getCardNumber();
                $expirationDate = $paymentProfile->getPayment()->getCreditCard()->getExpirationDate();
                $expiryMonth = substr($expirationDate, 5, 2);
                $expiryYear = substr($expirationDate, 0, 4);

                $billTo = $paymentProfile->getBillTo();
                $cardholderName = ($billTo != null) ? $billTo->getFirstName() . ' ' . $billTo->getLastName() : 'N/A';

                $paymentProfilesData[] = array(
                    'PaymentProfileID' => $paymentProfileId,
                    'CardType' => $paymentProfileType,
                    'CardNumber' => $paymentProfileNumber,
                    'ExpiryMonth' => $expiryMonth,
                    'ExpiryYear' => $expiryYear,
                    'CardholderName' => $cardholderName,
                );
            }

            // Create the API response array
            $apiResponse = array(
                'status' => 'success',
                'message' => 'Payment profiles retrieved successfully.',
                'paymentProfiles' => $paymentProfilesData,
            );

            // Convert the API response array to JSON
            // $jsonResponse = json_encode($apiResponse);

            // Return the JSON response
            return $apiResponse;
        } else {
            // If there was an error, return the error response in JSON format
            $errorMessages = $response->getMessages()->getMessage();
            $apiResponse = array(
                'status' => 'error',
                'message' => 'Error: GetCustomerProfile - ' . $errorMessages[0]->getText(),
            );

            $jsonResponse = json_encode($apiResponse);

            return $jsonResponse;
        }


    }

    
    

    


}
