<?php

namespace App\Transactions;

use App\Repository\VotesRepository;
use App\Sdkpayment\Hub2\Hub2authenticate;
use App\Sdkpayment\Hub2\Hub2payment;

class Payment
{
    protected $hub2authentication;
    protected $hub2payment;

    public function  __construct(Hub2authenticate $hub2authentication,
                                 Hub2payment $hub2payment)
    {
        $this->hub2authentication = $hub2authentication;
        $this->hub2payment = $hub2payment;
    }

    public function processTransaction($dataTransaction)
    {
        try {
            // Exemple : appel API paiement (Hub2)
            // Récupération du token d'authentification
            $authParams = [
                'customerReference' => $dataTransaction['transactionsId'],
                'purchaseReference' => $dataTransaction['transactionsRef'],
                'amount' => $dataTransaction['amount'],
                'currency' => $dataTransaction['currency'],
                'apiKey' => config('sdkpayment.HUB2_API_KEY'),
                'merchantId' => config('sdkpayment.HUB2_MERCHANT_ID'),
                'environment' => config('sdkpayment.HUB2_ENVIRONMENT'),
            ];
            $authResponse = $this->hub2authentication->authenticate($authParams);
            $token = $authResponse['token'];
            $id = $authResponse['id'];
            // Exécution du paiement
            $paymentParams = [
                'token' => $token,
                'id' => $id,
                'paymentMethod' => $dataTransaction['paymentMethod'],
                'countryCode' => $dataTransaction['countryCode'],
                'provider' => $dataTransaction['provider'],
                'phoneNumber' => $dataTransaction['phoneNumber'],
                'otpCode' => $dataTransaction['otpCode'],
            ];
            $paymentResponse = $this->hub2payment->executePayment($paymentParams);
            return $paymentResponse;


            // ⚠️ Ici appel réel au provider de paiement
//            $paymentSuccess = true;
//
//            if (! $paymentSuccess) {
//                throw new Exception('Paiement échoué');
//            }
//
//            return  $response = [
//                'status' => 'SUCCESS',
//                'transactions_id' => 'transaction_id',
//                'api_processing' => 'Détails du traitement API',
//                'api_response' => 'Réponse API complète',
//            ];

        } catch (\Throwable $e) {
            \Log::error('Erreur lors du traitement de la transaction hub2 : ' . $e->getMessage());
            return 'Erreur lors du traitement de la transaction hub2 : ' . $e->getMessage();
        }
    }

}

