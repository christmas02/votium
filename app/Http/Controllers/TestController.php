<?php

namespace App\Http\Controllers;


use App\Services\Setting;
use App\Services\VoteService;
use App\Transactions\ProcessPaymentHub2;
use App\Transactions\ProcessPaymentPaystack;

class TestController extends Controller
{
    protected $payment;
    protected $voteService;
    protected $setting;
    protected $paymentPaystack;

    public function __construct(ProcessPaymentHub2 $payment, VoteService $voteService,
    Setting $setting, ProcessPaymentPaystack $paymentPaystack)
    {
        $this->payment = $payment;
        $this->voteService = $voteService;
        $this->setting = $setting;
        $this->paymentPaystack = $paymentPaystack;

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
            'otpCode' => '0000',
            'email' => 'email',
            'name' => 'name',
            'amount' => 100,
            'phoneNumber' => '00000001',
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
