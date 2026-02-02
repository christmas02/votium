<?php

namespace App\Sdkpayment\Hyperfast;

use App\Sdkpayment\ClientHttpInstance;

class HyperfastAuthenticate
{
    private $client;

    public function __construct()
    {
        $this->client = ClientHttpInstance::getInstance();
    }

    public function authenticate(): array
    {
        try {

            $HYPERFAST_BASE_URL = config('sdkpayment.HYPERFAST_BASE_URL');
            $HYPERFAST_TOKEN_URL = config('sdkpayment.HYPERFAST_TOKEN_URL');

            $payload = [
                'email' => config('sdkpayment.HYPERFAST_EMAIL'),
                'password' => config('sdkpayment.HYPERFAST_PASSWORD')
            ];

            logger()->info('Hyperfast authentication request', [
                'url' => $HYPERFAST_BASE_URL . $HYPERFAST_TOKEN_URL,
                'payload' => $payload
            ]);

            $response = $this->client->request('POST', $HYPERFAST_BASE_URL . $HYPERFAST_TOKEN_URL, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'form_params' => $payload
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                logger()->info('Hyperfast authentication successful', ['response' => $body]);
                return $this->computeAuthenticateResponse($body);
            }

            logger()->error('Hyperfast authentication failed', [
                'status' => $statusCode,
                'response' => $body
            ]);

            throw new \Exception("Hyperfast API returned error: " . ($body['message'] ?? 'Unknown error'));

        } catch (\Exception $e) {
            throw new \Exception("Authentication failed: " . $e->getMessage());
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

            $result = [
                'success' => $response['success'],
                'accessToken' => $response['accessToken'],
                'expiresAt' => $response['expiresAt'],
            ];

            logger()->info('Hyperfast response computed successfully', $result);

            return $result;

        } catch (\Exception $e) {
            logger()->error('Failed to compute Hyperfast response', [
                'error' => $e->getMessage(),
                'response' => $response
            ]);
            throw new \Exception("Failed to process Hyperfast response: " . $e->getMessage());
        }
    }
}