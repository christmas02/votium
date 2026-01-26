<?php

namespace App\Sdkpayment\Paystack;

use App\Sdkpayment\ClientHttpInstance;

class Paystackautehticate
{
    private $client;

    public function __construct()
    {
        $this->client = ClientHttpInstance::getInstance();
    }


    public function authenticate(array $paramAuth): array
    {
        try{

            $PAYSTACK_BASE_URL = config('sdkpayment.PAYSTACK_BASE_URL');
            $PAYSTACK_INITIALIZE_URL = config('sdkpayment.PAYSTACK_INITIALIZE_URL');

            $payload = [
                'email' => $paramAuth['email'],
                'amount' => $paramAuth['amount']
            ];

            logger()->info('Paystack payment initialize request', [
                'url' => $PAYSTACK_BASE_URL . $PAYSTACK_INITIALIZE_URL,
                'payload' => $payload
            ]);

            $response = $this->client->request('POST', $PAYSTACK_BASE_URL . $PAYSTACK_INITIALIZE_URL, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $paramAuth['secretKey'],
                    'Content-Type' => 'application/json'
                ],
                'json' => $payload
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);

            logger()->info('Paystack payment initialize response', [
                'response' => $responseBody
            ]);

            return $responseBody;

        }catch(\Throwable $th){

            logger()->error('Error during Paystack authentication', [
                'error' => $th->getMessage()
            ]);

        }

    }
}