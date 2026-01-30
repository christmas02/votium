<?php

namespace App\Sdkpayment\Hyperfast;

use App\Sdkpayment\ClientHttpInstance;

class HyperfastPayment
{
    private $client;

    public function __construct()
    {
        $this->client = ClientHttpInstance::getInstance();
    }

    public function processPayment(array $paramPayment): array
    {
        try {
            $CALLBACK_URL = 'https://webhook.site/6cd2b75c-2dde-41c2-9276-4dc92cd76d58';
            $HYPERFAST_BASE_URL = config('sdkpayment.HYPERFAST_BASE_URL');
            $HYPERFAST_PAYMENT_URL = config('sdkpayment.HYPERFAST_PAYMENT_URL');

            $payload = [
                'phone' => $paramPayment['phone'],
                'amount' => $paramPayment['amount'],
                'metadata' => json_encode($paramPayment['metadata']),
                'callback' => $CALLBACK_URL,
                //'email' => $paramPayment['email']
            ];

            logger()->info('Hyperfast payment creation request', [
                'url' => $HYPERFAST_BASE_URL . $HYPERFAST_PAYMENT_URL,
                'payload' => $payload
            ]);

            $response = $this->client->request('POST', $HYPERFAST_BASE_URL . $HYPERFAST_PAYMENT_URL, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $paramPayment['access_token']
                ],
                'json' => $payload
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                logger()->info('Hyperfast execute payment  successful', ['response' => $body]);
                return $this->computeResponse($body);
            }

            logger()->error('Hyperfast execute payment failed', [
                'status' => $statusCode,
                'response' => $body
            ]);

            throw new \Exception("Hyperfast API returned error: " . ($body['message'] ?? 'Unknown error'));


        } catch (\Exception $e) {
            throw new \Exception("Payment creation failed: " . $e->getMessage());
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


   public function confirmPaymentOtp(array $paramOtp): array
   {
       try {

           $HYPERFAST_BASE_URL = config('sdkpayment.HYPERFAST_BASE_URL');
           $HYPERFAST_OTP_URL = config('sdkpayment.HYPERFAST_OTP_URL', '/api/v1/payment/otp');

           $payload = [
               'otp' => $paramOtp['otp'],
               'reference' => $paramOtp['reference'],
           ];

           logger()->info('Hyperfast OTP request', [
               'url' => rtrim($HYPERFAST_BASE_URL, '/') . $HYPERFAST_OTP_URL,
               'payload' => $payload
           ]);

           $response = $this->client->request('POST', rtrim($HYPERFAST_BASE_URL, '/') . $HYPERFAST_OTP_URL, [
               'headers' => [
                   'Accept' => 'application/json',
                   'Content-Type' => 'application/json',
                   'Authorization' => 'Bearer ' . $paramOtp['access_token']
               ],
               'json' => $payload
           ]);

           $statusCode = $response->getStatusCode();
           $body = json_decode($response->getBody()->getContents(), true);

           if ($statusCode >= 200 && $statusCode < 300) {
               logger()->info('Hyperfast OTP successful', ['response' => $body]);
               //return is_array($body) ? $body : ['raw' => $body];
               return $this->computeResponseOtp($body);
           }

           logger()->error('Hyperfast OTP failed', [
               'status' => $statusCode,
               'response' => $body
           ]);

           throw new \Exception("Hyperfast OTP API returned error: " . ($body['message'] ?? 'Unknown error'));
       } catch (\Throwable $e) {
           throw new \Exception("OTP execution failed: " . $e->getMessage());
       }
   }


   public function computeResponseOtp(array $response): array
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