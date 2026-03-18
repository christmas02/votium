<?php

namespace App\ApiTransfer;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class HyperfastTransfert
{
  
    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
            'timeout' => 30,
        ]);
    }


    public function transfer(string $access_token, string $phone, string $amount)
    {
        try {
            $BASE_URL = 'https://hyperfastpay.com/api/v1';
            $CALLBACK_URL = 'https://salaflex.com/transfer/check_status_transaction_hyperfastpay'; // Assurez-vous de configurer un CALLBACK_URL valide

            $body = [
                "phone" => $phone,
                "amount" => $amount,
                "callback" => $CALLBACK_URL
            ];

            $response = $this->client->request('POST', $BASE_URL . '/payout/momo/', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'  => 'application/json',
                    'Authorization' => 'Bearer ' . $access_token
                ],
                'body' => json_encode($body),
                'http_errors' => false
            ]);
          
            // Analysez la réponse
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody()->getContents(), true);

            if ($statusCode !== 200) {
                Log::warning("Traitement du transfert : HTTP $statusCode", ['response' => $responseBody]);
                throw new \Exception('Transfert traité : ' . ($responseBody['message'] ?? 'Erreur inconnue'));
            } else {
                Log::warning("Échec du transfert : HTTP $statusCode", ['response' => $responseBody]);
            }
            return [
                'statusCode' => $statusCode,
                'body' => $responseBody
            ]; // Retourner la réponse JSON décodée

        } catch (\Throwable $th) {
            Log::error("Erreur lors du transfert : " . $th->getMessage(), [
                'phone' => $phone,
                'amount' => $amount
            ]);
            throw $th;
        }
    }




}
