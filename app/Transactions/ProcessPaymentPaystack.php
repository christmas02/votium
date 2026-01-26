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
}