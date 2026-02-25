<?php

namespace App\Sdkpayment\Hub2;

use App\Sdkpayment\ClientHttpInstance;

class Hub2webhook
{
    private $client;

    public function __construct()
    {
        $this->client = ClientHttpInstance::getInstance();
    }

    public function createLinkWebhook()
    {
//        postman request POST 'https://api.hub2.io/webhooks/' \
//          --header 'Environment: {{environment}}' \
//          --header 'MerchantId: {{merchantId}}' \
//          --header 'Content-Type: application/json' \
//          --header 'ApiKey: ••••••' \
//          --body '{
//        "url":"",
//        "events": [
//            "transfer.created",
//            "transfer.processing",
//            "transfer.succeeded",
//            "transfer.failed"
//        ],
//        "description": "This is a webhook trigger upon transfer, payment & payment_intent creation",
//        "metadata": { }
//        }
//        ' \
//          --auth-apikey-key 'ApiKey' \
//          --auth-apikey-value '{{apiKey}}' \
//          --auth-apikey-in 'header'

        try {
            $HUB2_BASE_URL = config('sdkpayment.HUB2_BASE_URL');
            $response = $this->client->request('POST', $HUB2_BASE_URL.'webhooks/', [
                'headers' => [
                    'ApiKey' => config('sdkpayment.HUB2_API_KEY'),
                    'MerchantId' => config('sdkpayment.HUB2_MERCHANT_ID'),
                    'Environment' => config('sdkpayment.HUB2_ENVIRONMENT'),
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    "url" => config('sdkpayment.HUB2_WEBHOOK_URL'),
                    "events" => [
                        "transfer.created",
                        "transfer.processing",
                        "transfer.succeeded",
                        "transfer.failed"
                    ],
                    "description" => "This is a webhook trigger upon transfer, payment & payment_intent creation",
                    "metadata" => new \stdClass()
                ],
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                logger()->info('Hub2 create link webhook successful', ['response' => $body]);
                return $body;
            }

            logger()->error('Hub2 create link webhook failed', [
                'status' => $statusCode,
                'response' => $body
            ]);

            throw new \Exception("Hub2 API returned error: " . ($body['message'] ?? 'Unknown error'));

        } catch (\Exception $e) {
            logger()->error('Hub2 create link webhook error: '.$e->getMessage());
            throw new \Exception('Hub2 create link webhook error: '.$e->getMessage());
        }


    }


    public function computeResponse(array $response): array
    {
        return [
            'transaction_id' => $response['id'] ?? null,
            'status' => $response['status'] ?? null,
            // Ajoutez d'autres champs pertinents si nécessaire
        ];
    }

    public function handleWebhook(array $response): array
    {
        try {
            logger()->info('Hub2 webhook received', ['response' => $response]);
            // Traiter la réponse du webhook et mettre à jour la transaction en conséquence
            // Vous pouvez extraire les données nécessaires du tableau $response et les utiliser pour mettre à jour votre base de données
            // Par exemple :
            $transactionId = $response['id'] ?? null;
            $status = $response['status'] ?? null;
            // Mettez à jour votre transaction dans la base de données en fonction de l'ID et du statut
            // ...

            return [
                'transaction_id' => $transactionId,
                'status' => $status,
                // Ajoutez d'autres champs pertinents si nécessaire
            ];
        } catch (\Exception $e) {
            logger()->error('Hub2 webhook handling error: '.$e->getMessage());
            throw new \Exception('Hub2 webhook handling error: '.$e->getMessage());
        }
    }
}