<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Exception\PayPalConnectionException;


class PaymentController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $paypalConfig = config('services.paypal');

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['paypal_client_id'],
                $paypalConfig['paypal_client_secret']
            )
        );
        $this->apiContext->setConfig([
            'mode' => $paypalConfig['mode'],
        ]);
    }

    public function showPaymentForm()
    {
        return view('payment');
    }

    public function processPayment(Request $request)
    {
        $amount = new Amount();
        $amount->setCurrency('USD')
               ->setTotal(61.00); // Set the total amount for the payment
        

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('payment.success'))
                     ->setCancelUrl(route('payment.cancel'));

        $payment = new Payment();

        $payment->setIntent('sale')
                ->setPayer(new Payer(['payment_method' => 'paypal']))
                ->setTransactions([$transaction])
                ->setRedirectUrls($redirectUrls);

         try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
         } catch (\Exception $e) {
        //     // Handle payment creation error
             return redirect()->route('payment.cancel')->with('error', 'Payment creation failed.');
         }
    }

    public function paymentSuccess(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));

        try {
            $result = $payment->execute($execution, $this->apiContext);

            // Payment success logic goes here
            return redirect()->route('home')->with('success', 'Payment successful.');
        } catch (\Exception $e) {
            // Handle payment execution error
            return redirect()->route('payment.cancel')->with('error', 'Payment failed.');
        }
    }

    public function paymentCancel()
    {
        // Payment cancel logic goes here
        return redirect()->route('home')->with('warning', 'Payment cancelled.');
    }

    
    public function paymentbyanuj(Request $request)
    {
        return view('paymentbyanuj');
    }
}
