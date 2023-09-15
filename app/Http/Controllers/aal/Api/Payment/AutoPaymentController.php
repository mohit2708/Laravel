<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\ShippingAddress;

class AutoPaymentController extends Controller
{    
    
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        return view('paypalSubcription');
    }

    /**
     * createBillingPlans
     *
     * @param  mixed $request
     * @return void
     */
    public function createBillingPlans(Request $request)
    {
        dd("sdfsgjksh jsgsk");
        // Create a new billing plan
        if (! empty($_POST["plan_name"]) && ! empty($_POST["plan_description"])) {
            $plan = new Plan();
            dd($plan);
            $plan->setName($_POST["plan_name"])
                ->setDescription($_POST["plan_description"]);

            // Set billing plan definitions
            $paymentDefinition = new PaymentDefinition();
            $paymentDefinition->setName('Regular Payments')
                ->setType('REGULAR')
                ->setFrequency('DAY')
                ->setFrequencyInterval('1')
                ->setCycles('3')
                ->setAmount(new Currency(array(
                'value' => 3,
                'currency' => 'USD'
            )));

            // Set charge models
            $chargeModel = new ChargeModel();
            $chargeModel->setType('SHIPPING')->setAmount(new Currency(array(
                'value' => 1,
                'currency' => 'USD'
            )));
            $paymentDefinition->setChargeModels(array(
                $chargeModel
            ));

            // Set merchant preferences
            $merchantPreferences = new MerchantPreferences();
            $merchantPreferences->setReturnUrl('http://<host>/how-to-manage-recurring-payments-    using-paypal-subscriptions-in-php/index.php?status=success')
                ->setCancelUrl('http://<host>/how-to-manage-recurring-payments-using-paypal-    subscriptions-in-php/index.php?status=cancel')
                ->setAutoBillAmount('yes')
                ->setInitialFailAmountAction('CONTINUE')
                ->setMaxFailAttempts('0')
                ->setSetupFee(new Currency(array(
                'value' => 1,
                'currency' => 'USD'
            )));

            $plan->setPaymentDefinitions(array(
                $paymentDefinition
            ));
            $plan->setMerchantPreferences($merchantPreferences);

            try {
                $createdPlan = $plan->create($apiContext);
                try {
                    $patch = new Patch();
                    $value = new PayPalModel('{"state":"ACTIVE"}');
                    $patch->setOp('replace')
                        ->setPath('/')
                        ->setValue($value);
                    $patchRequest = new PatchRequest();
                    $patchRequest->addPatch($patch);
                    $createdPlan->update($patchRequest, $apiContext);
                    $patchedPlan = Plan::get($createdPlan->getId(), $apiContext);
                    
                    $this->createBillingAgreement();
                } catch (PayPal\Exception\PayPalConnectionException $ex) {
                    echo $ex->getCode();
                    echo $ex->getData();
                    die($ex);
                } catch (Exception $ex) {
                    die($ex);
                }

            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                echo $ex->getCode();
                echo $ex->getData();
                die($ex);
            } catch (Exception $ex) {
                die($ex);
            }
        }
    }
    
    /**
     * activeBillingPlan
     *
     * @param  mixed $request
     * @return void
     */
    public function activeBillingPlan(Request $request)
    {
        try {
            $patch = new Patch();
            $value = new PayPalModel('{"state":"ACTIVE"}');
            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);
            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);
            $createdPlan->update($patchRequest, $apiContext);
            $patchedPlan = Plan::get($createdPlan->getId(), $apiContext);
            
            $this->createBillingAgreement();
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
    }
    
    /**
     * createBillingAgreement
     *
     * @param  mixed $request
     * @return void
     */
    public function createBillingAgreement(Request $request)
    {
        // Create new agreement
        $startDate = date('c', time() + 3600);
        $agreement = new Agreement();
        $agreement->setName('PHP Tutorial Plan Subscription Agreement')
            ->setDescription('PHP Tutorial Plan Subscription Billing Agreement')
            ->setStartDate($startDate);

        // Set plan id
        $plan = new Plan();
        $plan->setId($patchedPlan->getId());
        $agreement->setPlan($plan);

        // Add payer type
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        // Adding shipping details
        $shippingAddress = new ShippingAddress();
        $shippingAddress->setLine1('111 First Street')
            ->setCity('Saratoga')
            ->setState('CA')
            ->setPostalCode('95070')
            ->setCountryCode('US');
        $agreement->setShippingAddress($shippingAddress);

        try {
            // Create agreement
            $agreement = $agreement->create($apiContext);
            
            // Extract approval URL to redirect user
            $approvalUrl = $agreement->getApprovalLink();
            
            header("Location: " . $approvalUrl);
            exit();
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
    }

    public function executePayment(Request $request)
    {
        if (!empty($_GET['status'])) {
            if($_GET['status'] == "success") {
                $token = $_GET['token'];
                $agreement = new \PayPal\Api\Agreement();
                
                try {
                    // Execute agreement
                    $agreement->execute($token, $apiContext);
                } catch (PayPal\Exception\PayPalConnectionException $ex) {
                    echo $ex->getCode();
                    echo $ex->getData();
                    die($ex);
                } catch (Exception $ex) {
                    die($ex);
                }
            } else {
                echo "user canceled agreement";
            }
            exit;
        }
    }
}
