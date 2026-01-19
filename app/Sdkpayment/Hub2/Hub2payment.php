<?php

namespace App\Sdkpayment\Hub2;

use App\Sdkpayment\ClientHttpInstance;

class  Hub2payment
{
    private $client;

    public function __construct()
    {
        $this->client = ClientHttpInstance::getInstance();
    }

    /**
     * Authenticate and create payment intent
     *  $paramAuth = [
     *  'token' => $token,
     *  'id' => $id,
     *  'paymentMethod' => $paymentMethod
     *  'countryCode' => $countryCode,
     *  'provider' => $provider,
     *  'phoneNumber' => $phoneNumber,
     *  'otpCode' => $otpCode,
     *  ];
     * @param array $paramAuth
     * @return array
     * @throws \Exception
     */
    public function executePayment(array $param): array
    {
        try {
            $HUB2_BASE_URL = config('sdkpayment.HUB2_BASE_URL');
            $HUB2_MAKE_TRANSFER_URL = config('sdkpayment.HUB2_MAKE_TRANSFER_URL');

            $payload = [
                'token' => $param['token'],
                'id' => $param['id'],
                'paymentMethod' => $param['paymentMethod'],
                'countryCode' => $param['countryCode'],
                'provider' => $param['provider'],
                'mobileMoney' => [
                    'msisdn' => $param['phoneNumber'],
                    'otp' => $param['otpCode'],
                ],
            ];

            logger()->info('Hub2 make payment request', [
                'url' => $HUB2_BASE_URL.'payment-intents/'.$param['id'].'/payments',
                'payload' => $payload
            ]);

            $response = $this->client->request('POST', $HUB2_BASE_URL.'payment-intents/'.$param['id'].'/payments', [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($payload),
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                logger()->info('Hub2 execute payment successful', ['response' => $body]);
                return $this->computeResponse($body);
            }

            logger()->error('Hub2 execute payment failed', [
                'status' => $statusCode,
                'response' => $body
            ]);

            throw new \Exception("Hub2 API returned error: " . ($body['message'] ?? 'Unknown error'));

        } catch (\Exception $e) {
            logger()->error('Hub2 execute payment exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception("Hub2 execute payment failed: " . $e->getMessage());
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
            $result = [
                'data' => $response,
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