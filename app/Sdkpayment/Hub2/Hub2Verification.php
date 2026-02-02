<?php

namespace App\Sdkpayment\Hub2;

use App\Sdkpayment\ClientHttpInstance;

class Hub2Verification
{
    private $client;

    public function __construct()
    {
        $this->client = ClientHttpInstance::getInstance();
    }

    public function executeVerification(array $param): array
    {
        try {
            $HUB2_BASE_URL = config('sdkpayment.HUB2_BASE_URL');

            logger()->info('Hub2 verification request', [
                'url' => $HUB2_BASE_URL.'payments/'.$param['pay_id'].'/status',
                'params' => $param
            ]);
            $response = $this->client->request('GET', $HUB2_BASE_URL.'payments/'.$param['pay_id'].'/status', [
                'headers' => [
                    'ApiKey' => $param['apiKey'],
                    'MerchantId' => $param['merchantId'],
                    'Environment' => $param['environment'],
                    'Content-Type' => 'application/json'
                ],
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                logger()->info('Hub2 execute verification transaction successful', ['response' => $body]);
                return $this->computeResponse($body);
            }

            logger()->error('Hub2 execute verification transaction failed', [
                'status' => $statusCode,
                'response' => $body
            ]);

            throw new \Exception("Hub2 API returned error: " . ($body['message'] ?? 'Unknown error'));

        } catch (\Exception $e) {
            logger()->error('Hub2 verification error: '.$e->getMessage());
            throw new \Exception('Hub2 verification error: '.$e->getMessage());
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
            logger()->info('Hub2 verification response computed successfully', $response);
            return $response;

        } catch (\Exception $e) {
            logger()->error('Failed to compute Hub2 verification response', [
                'error' => $e->getMessage(),
                'response' => $response
            ]);
            throw new \Exception("Failed to process verification Hub2 response: " . $e->getMessage());
        }
    }

}