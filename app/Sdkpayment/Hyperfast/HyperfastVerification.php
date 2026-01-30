<?php

namespace App\Sdkpayment\Hyperfast;

use App\Sdkpayment\ClientHttpInstance;

class  HyperfastVerification
{
    private $client;

    public function __construct()
    {
        $this->client = ClientHttpInstance::getInstance();
    }

    public function processVerification(array $paramVerification): array
    {
        try {
            $HYPERFAST_BASE_URL = config('sdkpayment.HYPERFAST_BASE_URL');
            $HYPERFAST_VERIFICATION_URL = config('sdkpayment.HYPERFAST_VERIFICATION_URL');

            logger()->info('Hyperfast verification request', [
                'url' => $HYPERFAST_BASE_URL . $HYPERFAST_VERIFICATION_URL,
            ]);

            $response = $this->client->request('GET', $HYPERFAST_BASE_URL . $HYPERFAST_VERIFICATION_URL .'/'.$paramVerification['transactionId'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $paramVerification['access_token']
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                logger()->info('Hyperfast verification successful', ['response' => $body]);
                //return $body;
                return $this->computeResponseVerification($body);
            }

            logger()->error('Hyperfast verification failed', [
                'status' => $statusCode,
                'response' => $body
            ]);

            throw new \Exception("Hyperfast API returned error: " . ($body['message'] ?? 'Unknown error'));

        } catch (\Exception $e) {
            throw new \Exception("Verification failed: " . $e->getMessage());
        }
    }

    public function computeResponseVerification(array $response): array
    {
        try {

            $transactionData = $response['transaction'];
            return [
                'success' => $response['success'],
                'reference' => $transactionData['id'],
                'status' => $transactionData['status'],
                'phone' => $transactionData['phone'],
                'created_at' => $transactionData['created_at'],
                'metadata' => $transactionData['metadata'],
            ];

        } catch (\Exception $e) {
            logger()->error('Failed to compute Hyperfast response', [
                'error' => $e->getMessage(),
                'response' => $response
            ]);
            throw new \Exception("Failed to process Hyperfast response: " . $e->getMessage());
        }
    }
}