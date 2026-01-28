<?php

namespace App\Transactions;

use App\Sdkpayment\Paystack\Paystackautehticate;

class ProcessPaymentPaystack
{
    protected $paystackAuthentication;

    public function __construct(Paystackautehticate $paystackAuthentication)
    {
        $this->paystackAuthentication = $paystackAuthentication;
    }

    public function execute(array $dataTransaction): array
    {
        try {
            // Logic to process payment using Paystack API
            // This is a placeholder for actual implementation

            // Authentification
            $authParams = [
                'amount' => $dataTransaction['amount'],
                'email' => $dataTransaction['email'],
                'secretKey' => config('sdkpayment.PAYSTACK_SECRET_KEY'),
            ];

            return $this->paystackAuthentication->authenticate($authParams);


        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Une erreur est survenue lors du traitement du paiement: ' . $e->getMessage(),
                'transactions_id' => $dataTransaction['transaction_id'] ?? null,
            ];
        }

    }

    public function testInitCharge(array $paramTransaction): array
    {
        try {

            $authParams = [
                'amount' => $paramTransaction['amount'],
                'email' => $paramTransaction['email'],
                'phone' => $paramTransaction['phone'],
                'currency' => $paramTransaction['currency'],
                'provider' => $paramTransaction['provider'],
                'secretKey' => config('sdkpayment.PAYSTACK_SECRET_KEY'),
            ];
            return $this->paystackAuthentication->initCharge($authParams);

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Une erreur est survenue lors du traitement du paiement: ' . $e->getMessage(),
                'transactions_id' => $paramTransaction['transaction_id'] ?? null,
            ];
        }
    }
}