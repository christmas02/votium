<?php

namespace App\Sdkpayment\Hub2;

use App\Sdkpayment\ClientHttpInstance;

class Hub2authenticate
{
    private $client;

    public function __construct()
    {
        $this->client = ClientHttpInstance::getInstance();
    }

    /**
     * Authenticate and create payment intent
     *  $paramAuth = [
     *  'apiKey' => $apiKey,
     *  'merchantId' => $merchantId,
     *  'environment' => $environment,
     *  'customerReference' => $customerReference,
     *  'purchaseReference' => $purchaseReference,
     *  'amount' => $amount,
     *  'currency' => $currency,
     *  ];
     * @param array $paramAuth
     * @return array
     * @throws \Exception
     */
    public function authenticate(array $paramAuth): array
    {
        // Validation des paramètres requis
        $requiredFields = ['apiKey', 'merchantId', 'environment', 'customerReference', 'purchaseReference', 'amount', 'currency'];
        foreach ($requiredFields as $field) {
            if (empty($paramAuth[$field])) {
                throw new \Exception("Missing required parameter: {$field}");
            }
        }

        try {
            $HUB2_BASE_URL = config('sdkpayment.HUB2_BASE_URL');
            $PAYMENT_INTENT = config('sdkpayment.HUB2_PAYMENT_INTENT_URL');

            $payload = [
                'customerReference' => $paramAuth['customerReference'],
                'purchaseReference' => $paramAuth['purchaseReference'],
                'amount' => $paramAuth['amount'],
                'currency' => $paramAuth['currency']
            ];

            logger()->info('Hub2 payment intent request', [
                'url' => $HUB2_BASE_URL . $PAYMENT_INTENT,
                'payload' => $payload
            ]);

            $response = $this->client->request('POST', $HUB2_BASE_URL . $PAYMENT_INTENT, [
                'headers' => [
                    'ApiKey' => $paramAuth['apiKey'],
                    'MerchantId' => $paramAuth['merchantId'],
                    'Environment' => $paramAuth['environment'],
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($payload),
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                logger()->info('Hub2 authentication successful', ['response' => $body]);
                return $this->computeAuthenticateResponse($body);
            }

            logger()->error('Hub2 authentication failed', [
                'status' => $statusCode,
                'response' => $body
            ]);

            throw new \Exception("Hub2 API returned error: " . ($body['message'] ?? 'Unknown error'));

        } catch (\Exception $e) {
            logger()->error('Hub2 authentication exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception("Hub2 authentication failed: " . $e->getMessage());
        }
    }

    /**
     * Extract relevant data from authentication response
     *
     * @param array $response
     * @return array
     * @throws \Exception
     */
    private function computeAuthenticateResponse(array $response): array
    {
        try {
            if (!isset($response['id']) || !isset($response['token'])) {
                throw new \Exception('Invalid response structure: missing id or token');
            }

            $result = [
                'id' => $response['id'],
                'token' => $response['token'],
                'date' => $response,
            ];

            logger()->info('Hub2 response computed successfully', $result);

            return $result;

        } catch (\Exception $e) {
            logger()->error('Failed to compute Hub2 response', [
                'error' => $e->getMessage(),
                'response' => $response
            ]);
            throw new \Exception("Failed to process Hub2 response: " . $e->getMessage());
        }
    }
}