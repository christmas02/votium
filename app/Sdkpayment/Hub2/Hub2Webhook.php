<?php

namespace App\Sdkpayment\Hub2;

use App\Sdkpayment\ClientHttpInstance;
use Illuminate\Support\Facades\Log;

class Hub2Webhook
{
    private $client;

    public function __construct()
    {
        $this->client = ClientHttpInstance::getInstance();
    }

    public function createLinkWebhook()
    {
        try {
            $HUB2_BASE_URL = config('sdkpayment.HUB2_BASE_URL');
            $url = rtrim($HUB2_BASE_URL, '/') . '/webhooks/';

            $payload = [
                'url' => "https://webhook.site/1e3b7f56-c38c-41df-a5c4-a2c43440b4c2",
                "events" => [
                    "transfer.created",
                    "transfer.processing",
                    "transfer.succeeded",
                    "transfer.failed",
                    "payment.created",
                    "payment.pending",
                    "payment.succeeded",
                    "payment.failed",
                ],
                'description' => "This is a webhook trigger upon transfer, payment & payment_intent creation",,
                "metadata" => new \stdClass()
            ];

            logger()->info('Hub2 execute create link webhook request', [
                'url' => $url,
                'payload' => $payload
            ]);

            $response = $this->client->request('POST', $url, [
                'headers' => [
                    'ApiKey' => config('sdkpayment.HUB2_API_KEY'),
                    'MerchantId' => config('sdkpayment.HUB2_MERCHANT_ID'),
                    'Environment' => config('sdkpayment.HUB2_ENVIRONMENT'),
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($payload),
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

    public function handleWebhook(array $payload): array
    {
        try {
            logger()->info('Hub2 webhook received', ['payload' => $payload]);
            // Traiter la réponse du webhook et mettre à jour la transaction en conséquence
    
            $datas = $payload['data'] ?? null;
            $status = $datas['status'] ?? null;
            $reference = $datas['id'] ?? null;

            // Cherche la transaction par plusieurs colonnes possibles
            $transaction = Transaction::where('transaction_id_partner', $reference)->first();

            if (! $transaction) {
                Log::warning('Hub2 webhook: transaction not found', ['reference' => $reference, 'payload' => $payload]);
                //DB::rollBack();
            }
            // Mise à jour des champs s'ils sont fournis
            $status = $payload['status'] ?? null;
            if ($status === 'success') {
                $tr_status = 'completed';
                $comment = 'Payment successful';
            } elseif ($status === 'failed') {
                $tr_status = 'failed';
                $comment = 'Payment failed';
            } elseif ($status === 'pending') {
                $tr_status = 'pending';
                $comment = 'Payment pending';
            } else {
                $tr_status = 'processing';
                $comment = 'Payment processing';
            }

            if (isset($payload['status'])) {
                $transaction->status = $tr_status;
            }
            $transaction->response_init_payment = is_array($payload) ? json_encode($payload) : $payload;
            $transaction->comment = $comment;
            $transaction->save();

            $response = $transaction->toArray();

            //DB::commit();
            Log::info('Hyperfast webhook: transaction updated', ['id' => $transaction->transaction_id, 'reference' => $reference]);
            return $response;
            
        } catch (\Exception $e) {
            logger()->error('Hub2 webhook handling error: ' . $e->getMessage(), ['payload' => $payload]);
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

}