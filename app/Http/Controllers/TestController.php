<?php

namespace App\Http\Controllers;

use App\Sdkpayment\Hyperfast\HyperfastAuthenticate;
use App\Sdkpayment\Hyperfast\HyperfastPayment;
use App\Sdkpayment\Hyperfast\HyperfastVerification;
use App\Services\Setting;
use App\Services\VoteService;
use App\Transaction\Payments\ProcessPaymentHub2;
use App\Transaction\Payments\ProcessPaymentHyperfast;
use App\Transaction\Payments\ProcessPaymentPaystack;

class TestController extends Controller
{
    protected $payment;
    protected $voteService;
    protected $setting;
    protected $paymentPaystack;
    protected $paymentHyperfast;

    public function __construct(ProcessPaymentHub2 $payment,
                                VoteService $voteService,
                                Setting $setting,
                                ProcessPaymentPaystack $paymentPaystack,
                                HyperfastAuthenticate $hyperfastAuthenticate,
                                HyperfastPayment $hyperfastPayment,
                                HyperfastVerification $hyperfastVerification,
                                ProcessPaymentHyperfast $paymentHyperfast)
    {
        $this->payment = $payment;
        $this->voteService = $voteService;
        $this->setting = $setting;
        $this->paymentPaystack = $paymentPaystack;
        $this->hyperfastAuthenticate = $hyperfastAuthenticate;
        $this->hyperfastPayment = $hyperfastPayment;
        $this->hyperfastVerification = $hyperfastVerification;
        $this->paymentHyperfast = $paymentHyperfast;

    }

    public function checkStatusTransaction()
    {
        $data = '415c767b-4210-49ef-9158-25b505a3e6ac';
        return $this->voteService->checkStatusTransaction($data);
    }

    public function testHyperfast()
    {
        try {

            $auth = $this->hyperfastAuthenticate->authenticate();
            $token = $auth['accessToken'];
//            {
//                "success": true,
//              "accessToken": "924522|j48QOn8m6Yfx0jHMg8hKS2sMyRkdTKFqagscmSAjdf62a1d9",
//              "expiresAt": "2026-01-30T02:31:22.000000Z"
//            }
            $paramTransaction = [
                'amount' => 100,
                'phone' => '0748997945',
                //'email' => 'custoner@gmail.com',
                'metadata' => ['customer' => 'dupont', 'order_id' => '1234'],
                'access_token' => $token,
            ];
            $payment = $this->hyperfastPayment->processPayment($paramTransaction);
//            {
//              "success": true,
//              "status": "pending",
//              "message": "Please complete authorization process on your mobile application",
//              "transactionId": "RAL.1769725678.9713",
//              "totalAmount": 100,
//              "fee": 0
//            }
            $paramOtp = [
                'otp' => '0974',
                'reference' => $payment['transactionId'],
                'access_token' => $token,
            ];
            $confirmPayment = $this->hyperfastPayment->confirmPaymentOtp($paramOtp);
//            {
//                "success": false,
//              "status": "failed",
//              "message": "ERROR",
//              "description": "Code is incorrect.Your payment cannot be processed.",
//              "transactionId": "RAM.1769733560.3055"
//            }
            $data = [
                'transactionId' => $confirmPayment['transactionId'],
                'access_token' => $token,
            ];

            return $this->hyperfastVerification->processVerifcation($data);
//            {
//                "success": true,
//  "transaction": {
//                "id": "RMA.1769738360.5062",
//    "phone": "0748997945",
//    "carrier": "Orange",
//    "amount": 100,
//    "currency": "XOF",
//    "status": "pending",
//    "carrier_transaction_id": null,
//    "created_at": "2026-01-30T01:59:20.000000Z",
//    "processed_at": null,
//    "metadata": "{\"customer\":\"dupont\",\"order_id\":\"1234\"}",
//    "comment": null
//  }
//}


        } catch (\Throwable $e) {
            //
            dd($e);
        }

    }





    public function testPaystackpayment()
    {
//        $paramTransaction = [
//            'amount' => 200,
//            'email' => 'customer@mail.com',
//        ];
//        return $this->paymentPaystack->execute($paramTransaction);

        $paramTransaction = [
            'amount' => 200,
            'email' => 'customer@mail.com',
            'currency' => 'CFA',
            'phone' => '0551234987',
            'provider' => 'mtn',
        ];
        return $this->paymentPaystack->testInitCharge($paramTransaction);
    }
    public function testProcessVote()
    {
        $data = [
            'vote_id' => $this->setting->generateUuid(),
            'candidat_id' => $this->setting->generateUuid(),
            'campagne_id' => $this->setting->generateUuid(),
            'etate_id' => $this->setting->generateUuid(),
            'quantity' => 1,
            'otpCode' => '5419',
            'email' => 'email',
            'name' => 'name',
            'amount' => 100,
            'phoneNumber' => '0748997945',
            'provider' => 'orange',
        ];
        return $this->voteService->processVote($data);
    }

    public function testHub2payment()
    {
        try {
            $paramTransaction = [
                'transaction_id' => '719577b7-cd07-4257-b5c1-c491830fb5da',
                'amount' => 200,
                'currency' => 'XOF',
                'country' => 'CI',
                'provider' => 'orange',
                'phoneNumber' => '00000001',
                'otpCode' => '0000',
            ];
            return $this->payment->execute($paramTransaction);
            //return ['payment_id' => $transaction['payment']['payment_id']];
                //'payment_id' => $transaction

        } catch (\Throwable $e) {
            //
            dd($e);
        }

    }
}
