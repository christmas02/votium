<?php

namespace App\Http\Controllers;

use App\Transactions\Payment;

class TestController extends Controller
{
    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }
    public function testHub2payment()
    {
        try {
            $paramTransaction = [
                'transactionsId' => 'TX123'.time(),
                'transactionsRef' => 'ORD98'.date('YmdHis'),
                'amount' => 200,
                'currency' => 'XOF',
                'paymentMethod' => 'mobile_money',
                'countryCode' => 'CI',
                'provider' => 'orange',
                'phoneNumber' => '2250748997945',
                'otpCode' => '0000',
            ];
            $transaction =  $this->payment->processTransaction($paramTransaction);
            return $response = [
                'data' => $transaction
            ];
        } catch (\Throwable $e) {
            //
            dd($e);
        }

    }
}
