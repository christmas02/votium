<?php

namespace App\ApiTransfer;

use App\Sdkpayment\ClientHttpInstance;

class HyperfastBalance
{
    private $client;

    public function __construct()
    {
        $this->client = ClientHttpInstance::getInstance();
    }

    public function get_balance(string $accessToken): array
    {
        try {
            $HYPERFAST_BASE_URL = config('sdkpayment.HYPERFAST_BASE_URL');
            $HYPERFAST_BALANCE_URL = config('sdkpayment.HYPERFAST_BALANCE_URL');

            logger()->info('Hyperfast balance request', [
                'url' => $HYPERFAST_BASE_URL . $HYPERFAST_BALANCE_URL,
            ]);

            $response = $this->client->request('GET', $HYPERFAST_BASE_URL . $HYPERFAST_BALANCE_URL, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $accessToken
                ]
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                logger()->info('Hyperfast balance retrieval successful', ['response' => $body]);
                return $this->computeBalanceResponse($body);
            }

            logger()->error('Hyperfast balance retrieval failed', [
                'status' => $statusCode,
                'response' => $body
            ]);

            throw new \Exception("Hyperfast API returned error: " . ($body['message'] ?? 'Unknown error'));

        } catch (\Exception $e) {
            throw new \Exception("Balance retrieval failed: " . $e->getMessage());
        }
    }


    /**
     * Extract relevant data from authentication response
     *
     * @param array $response
     * @return array
     * @throws \Exception
     */
    private function computeResponse(array $response): array
    {
        try {

            return $response;

        } catch (\Exception $e) {
            logger()->error('Failed to compute Hyperfast response', [
                'error' => $e->getMessage(),
                'response' => $response
            ]);
            throw new \Exception("Failed to process Hyperfast response: " . $e->getMessage());
        }
    }

}