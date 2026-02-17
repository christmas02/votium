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
        // Validation des paramètres requis
        $requiredFields = ['token', 'id', 'paymentMethod', 'country', 'provider', 'phoneNumber'];
        foreach ($requiredFields as $field) {
            if (empty($param[$field])) {
                throw new \Exception("Missing required parameter: {$field}");
            }
        }

        try {
            $HUB2_BASE_URL = config('sdkpayment.HUB2_BASE_URL');
            // Construction de l'URL avec l'ID de l'intent
            $url = rtrim($HUB2_BASE_URL, '/') . '/payment-intents/' . $param['id'] . '/payments';

            $payload = [
                'token' => $param['token'],
                'paymentMethod' => $param['paymentMethod'],
                'country' => $param['country'],
                'provider' => $param['provider'],
                'mobileMoney' => [
                    'msisdn' => $param['phoneNumber'],
                    'otp' => $param['otpCode'] ?? null
                ],
            ];

            logger()->info('Hub2 execute payment request', [
                'url' => $url,
                'intent_id' => $param['id'],
                'payload' => $payload
            ]);

            $response = $this->client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($payload),
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                logger()->info('Hub2 execute payment successful', [
                    'status' => $statusCode,
                    'response' => $body
                ]);
                return $this->computeExecutePaymentResponse($body);
            }

            logger()->error('Hub2 execute payment failed', [
                'status' => $statusCode,
                'response' => $body
            ]);

            return [
                'error' => true,
                'status' => $statusCode,
                'response' => $body,
                'message' => $body['message'] ?? 'Unknown error'
            ];

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
    private function computeExecutePaymentResponse(array $response): array
    {
        try {

            // Construction de la réponse structurée
            $result = [
                // Informations principales de l'intent
                'intent_id' => $response['id'],
                'token' => $response['token'],
                'status' => $response['status'],
                'mode' => $response['mode'] ?? null,

                // Références
                'customer_reference' => $response['customerReference'] ?? null,
                'purchase_reference' => $response['purchaseReference'] ?? null,

                // Montants
                'amount' => $response['amount'] ?? null,
                'currency' => $response['currency'] ?? null,

                // Merchant
                'merchant_id' => $response['merchantId'] ?? null,
                'override_business_name' => $response['overrideBusinessName'] ?? null,

                // Dates
                'created_at' => $response['createdAt'] ?? null,
                'updated_at' => $response['updatedAt'] ?? null,

                // Informations sur le paiement
                'payment' => null,

                // Totaux calculés
                'total_fees' => 0,
                'total_taxes' => 0,
                'total_amount' => $response['amount'] ?? 0,
            ];

            // Extraction des informations de paiement (premier paiement)
            if (isset($response['payments']) && is_array($response['payments']) && count($response['payments']) > 0) {
                $payment = $response['payments'][0];

                $result['payment'] = [
                    'payment_id' => $payment['id'] ?? null,
                    'intent_id' => $payment['intentId'] ?? null,
                    'status' => $payment['status'] ?? null,
                    'method' => $payment['method'] ?? null,
                    'provider' => $payment['provider'] ?? null,
                    'country' => $payment['country'] ?? null,
                    'number' => $payment['number'] ?? null,
                    'amount' => $payment['amount'] ?? null,
                    'currency' => $payment['currency'] ?? null,
                    'created_at' => $payment['createdAt'] ?? null,
                    'updated_at' => $payment['updatedAt'] ?? null,
                    'fees' => []
                ];

                // Extraction des frais
                if (isset($payment['fees']) && is_array($payment['fees'])) {
                    foreach ($payment['fees'] as $fee) {
                        $feeData = [
                            'fee_id' => $fee['id'] ?? null,
                            'amount' => $fee['amount'] ?? 0,
                            'currency' => $fee['currency'] ?? null,
                            'label' => $fee['label'] ?? null,
                            'rate' => $fee['rate'] ?? null,
                            'rate_type' => $fee['rateType'] ?? null,
                            'taxes' => []
                        ];

                        // Calcul du total des frais
                        $result['total_fees'] += $fee['amount'] ?? 0;

                        // Extraction des taxes
                        if (isset($fee['taxes']) && is_array($fee['taxes'])) {
                            foreach ($fee['taxes'] as $tax) {
                                $taxData = [
                                    'tax_id' => $tax['id'] ?? null,
                                    'fee_id' => $tax['feeId'] ?? null,
                                    'tax_type' => $tax['taxType'] ?? null,
                                    'type' => $tax['type'] ?? null,
                                    'value' => $tax['value'] ?? 0
                                ];

                                $feeData['taxes'][] = $taxData;

                                // Calcul du total des taxes
                                $result['total_taxes'] += $tax['value'] ?? 0;
                            }
                        }

                        $result['payment']['fees'][] = $feeData;
                    }
                }
            }

            // Calcul du montant total (montant initial + frais + taxes)
            $result['total_amount'] = ($result['amount'] ?? 0) + $result['total_fees'] + $result['total_taxes'];

            logger()->info('Hub2 payment response computed successfully', [
                'intent_id' => $result['intent_id'],
                'status' => $result['status'],
                'amount' => $result['amount'],
                'total_fees' => $result['total_fees'],
                'total_taxes' => $result['total_taxes'],
                'total_amount' => $result['total_amount']
            ]);

            return $result;

        } catch (\Exception $e) {
            logger()->error('Failed to compute Hub2 payment response', [
                'error' => $e->getMessage(),
                'response' => $response
            ]);
            throw new \Exception("Failed to process Hub2 response: " . $e->getMessage());
        }
    }

}