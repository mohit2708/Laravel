<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
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
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;


use PayPal\Api\PayoutRecipient;
use PayPal\Api\Payout;
use PayPal\Api\PayoutItem;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Api\PayoutItemDetails;


class PayPalInbuildPackageController extends Controller
{

    public function ApiContext()
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );
        return $apiContext;
    }

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

        $amount = new Amount();
        $amount->setTotal('124');
        $amount->setCurrency('USD'); // Change this if you're using a different currency

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.execute'))
            ->setCancelUrl(route('paypal.cancel'));

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

            try {
                 $payment->create($apiContext);
                // dd($pay1);
                
        } catch (\PayPal\Exception\PayPalConnectionException $e) {
            // Handle any exceptions that might occur during API call
            // e.g., $e->getCode(), $e->getData()
            return response()->json(['error' => 'Payment could not be processed. Please try again later.'], 500);
        }

        $approvalUrl = $payment->getApprovalLink();
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

        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');

        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
 
        try {
            $result = $payment->execute($execution, $apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $e) {
            // Handle any exceptions that might occur during API call
            // e.g., $e->getCode(), $e->getData()
            return response()->json(['error' => 'Payment could not be processed. Please try again later.'], 500);
        }

        // Payment completed successfully, you can process the payment details here
        return response()->json(['success' => 'Payment successful! Thank you for your purchase.']);
    }

    public function cancelPayment()
    {
        // Handle the case when the user cancels the payment
        return response()->json(['error' => 'Payment cancelled.'], 500);
    }

    public function AutoWalletRecharge(Request $request){
       
        $apiContext = (new PayPalTokenController)->getApiContext();

        $amount = new Amount();
        $amount->setTotal(105.0) // Amount to recharge
            ->setCurrency('USD'); // Currency

        // Set the payer
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        // Set the transaction
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription('Auto Wallet Recharge');

        // Set the redirect URLs
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(url('/auto-wallet-recharge/success'))
            ->setCancelUrl(url('/auto-wallet-recharge/cancel'));

        // Create the payment
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);
            $approvalUrl = $payment->getApprovalLink();
            dd($approvalUrl);

            return redirect($approvalUrl); // Redirect to PayPal for payment approval
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error initiating wallet recharge: ' . $e->getMessage()], 500);
        }

        die('asdff');

        $senderBatchId = uniqid(); // Unique batch ID for tracking purposes

        $payout = new Payout();
        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId($senderBatchId)
            ->setEmailSubject('Money Transfer');

        $payout->setSenderBatchHeader($senderBatchHeader);

        $payoutItem = new PayoutItem();
        $payoutItem->setRecipientType('EMAIL')
            ->setReceiver('business@example.com') // Business account email
            ->setAmount(new Currency('USD', 100.0)) // Amount and currency
            ->setSenderItemId('item_' . uniqid()) // Unique item ID
            ->setNote('Money transfer note'); // Note for the payout item

        $payout->addItem($payoutItem);

        try {
            $payout->create(null, $apiContext);
            return response()->json(['message' => 'Money transfer initiated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error initiating money transfer: ' . $e->getMessage()], 500);
        }

        die();

        $recipientEmail = 'mohits4@yopmail.com';
        
        // Amount to transfer
        $amount = 102;

        // Create a new Payout object
        $payout = new Payout();
        $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();

        // Set the sender's email (business account email)
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject('You received a payment.');

        $payoutsItem = new \PayPal\Api\PayoutItem();
        $payoutsItem->setRecipientType('Email')
            ->setReceiver($recipientEmail)
            ->setAmount(new Currency(array('value' => $amount, 'currency' => 'USD')));
            dd($payoutsItem);

        $payout->setSenderBatchHeader($senderBatchHeader)
            ->addItem($payoutsItem);

        try {
            // Send the payout request
            $payout->create(null, $this->apiContext());

            // Payout successful
            return response()->json(['message' => 'Money transferred successfully.']);
        } catch (\Exception $ex) {
            // Handle payout failure
            return response()->json(['error' => 'Money transfer failed.'], 500);
        }
        dd('sfa');

        $payer_email = 'mohits4@chetu.com';

        // $this->validate($request, [
        //     'payer_email' => 'required|email',
        // ]);

        $amount = 100.00; // The payment amount
        $payerEmail = $request->input($payer_email);
        $businessEmail = 'sb-vhqr226878002@business.example.com'; // Your business account email

        // Create a new Payer with the payer's email
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $payer->setPayerInfo(new \PayPal\Api\PayerInfo(array('email' => $payerEmail)));

        // Create an Amount object with the payment amount
        $paymentAmount = new Amount();
        $paymentAmount->setCurrency('USD');
        $paymentAmount->setTotal($amount);

        // Create a new Transaction with the Amount
        $transaction = new Transaction();
        $transaction->setAmount($paymentAmount);

        // Create a new Payment with the Transaction and Payer
        $payment = new Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setTransactions(array($transaction));

        // Set the Redirect URLs for successful and canceled payments
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.execute'));
        $redirectUrls->setCancelUrl(route('paypal.cancel'));

        $payment->setRedirectUrls($redirectUrls);

        // Create the payment in PayPal
        try {
            $payment->create($this->apiContext());
        } catch (\Exception $ex) {
            // Handle error
            return response()->json(['error' => 'Payment creation failed.'], 500);
        }

        // Get the approval URL and return it in the API response
        $approvalUrl = $payment->getApprovalLink();
        return response()->json(['approval_url' => $approvalUrl]);


        dd('asf');
        // $user = Auth::user();
        // dd($user);
        // $user = Auth::user();
        // $defaultPayPalAccount = $user->default_paypal_account; 
        
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => "User not found"
            ]);
        }
        $defaultPayPalAccount = "GLZEFBVHFZQQQ"; // Replace with the appropriate column name for the payer's PayPal email or account ID
        

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );

        // Step 3: Implement the Payout
        $payout = new Payout();
        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject('You have received a payout!');

        // Create a PayoutItem object
        $payoutItem = new PayoutItem();
        $payoutItem->setRecipientType('EMAIL') // Set the recipient type to 'EMAIL' for email-based recipients
            ->setReceiver('mohits4@yopmail.com') // Set the recipient's email address
            ->setNote('Wallet Recharge');

        // Set the payout amount using the Currency object
        $amount = new Currency();
        $amount->setCurrency('USD')->setValue('500.00');
        $payoutItem->setAmount($amount);
        $payout->setSenderBatchHeader($senderBatchHeader)
        ->addItem($payoutItem);
    
        try {
            // Handle successful payout response, if needed
            $payout->create(null, $apiContext);
            
            $newBalance = $user->min_wallet_bal + 500; // Update the balance with the recharge amount
            $user->where('id', $user->id)->update(['min_wallet_bal' => $user->min_wallet_bal + 500]);

            return response()->json(['message' => 'Money added to the default PayPal account successfully.']);
        } catch (\Exception $ex) {
            // Handle errors from the Payouts API or database update
            return response()->json(['error' => 'Failed to add money to the default PayPal account.', 'error_details' => $ex->getMessage()], 500);
        }



        dd("upar try");
        // dd($request->user_id);
        // $userId = Auth::user()->id;
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => "User not found"
            ]);
        }
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );
        $min_wallet_bal =  (float) $user->min_wallet_bal;
        // return $min_wallet_bal;
        $walletThreshold = 200; // Set the wallet balance threshold
        if ($min_wallet_bal < $walletThreshold) {
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $amount = new Amount();
            $amount->setTotal($walletThreshold); // Total amount to be paid via PayPal
            $amount->setCurrency('USD');

            $transaction = new Transaction();
            $transaction->setAmount($amount);
            // ... (Add other transaction details as needed) ...

            // Create a redirect URLs object
            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(route('paypal.execute')); // URL to handle payment execution
            $redirectUrls->setCancelUrl(route('paypal.cancel')); // URL to handle payment cancellation

            // Create a payment object
            $payment = new Payment();
            $payment->setIntent('sale');
            $payment->setPayer($payer);
            $payment->setTransactions([$transaction]);
            $payment->setRedirectUrls($redirectUrls);
            // dd($payment);

            // Create the payment on PayPal
            try {
                $payment->create($apiContext);
            } catch (Exception $ex) {
                // Handle PayPal API connection errors or other exceptions
                return response()->json(['error' => 'Failed to create the payment.', 'error_details' => $ex->getMessage()], 500);
            }

            // Get the PayPal redirect URL and redirect the user to PayPal for payment
            $approvalUrl = $payment->getApprovalLink();
            return response()->json(['approval_url' => $approvalUrl]);
        } else {
            // The wallet amount is sufficient, show a message to the user
            return response()->json(['message' => 'Wallet balance is sufficient, no need to make a PayPal payment.']);
        }
        
    }


    public function ajeetautowallet(){
        $apiContext = (new PayPalTokenController)->getApiContext();

        $existingAgreementID = False; // Replace with actual agreement ID

        if (!$existingAgreementID) {
            // Create a new agreement using the previously defined plan
            $agreement = new Agreement();
            $agreement->setName('Auto Top-Up Subscription')
                ->setDescription('Automatically top up wallet balance')
                ->setStartDate(date('Y-m-d\TH:i:s\Z', strtotime('+1 day'))); // Start in one day

            $plan = new Plan();
            $plan->setId('P-9BH57362SV480213R2VU446Y'); // Replace with your Plan ID

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $agreement->setPlan($plan)
                ->setPayer($payer);
        

            // Create agreement and activate without approval
            try {
                $createdAgreement = $agreement->create($apiContext);
                

                // Store the agreement ID in your database for future reference
                // $newAgreementID = $createdAgreement->getId();
                $retrievedAgreement = Agreement::get($createdAgreement->getId(), $apiContext);
                $newAgreementID = $retrievedAgreement->getId();
                var_dump($retrievedAgreement);
               
                // ... Store $newAgreementID in your database

                echo "Auto Top-Up Agreement Created and Activated! ".$newAgreementID;
            } catch (Exception $e) {
                // Handle errors
                echo 'Error: ' . $e->getMessage();
            }
        } else {
            // Agreement already exists, no need for approval
            echo "Auto Top-Up Agreement already active!";
        }
    }

}
