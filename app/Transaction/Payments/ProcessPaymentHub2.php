<?php

namespace App\Transaction\Payments;

use App\Models\Transaction;
use App\Sdkpayment\Hub2\Hub2authenticate;
use App\Sdkpayment\Hub2\Hub2payment;
use App\Sdkpayment\Hub2\Hub2Verification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessPaymentHub2
{
    protected $hub2authentication;
    protected $hub2payment;
    protected $hub2verification;

    public function __construct(
        Hub2authenticate $hub2authentication,
        Hub2payment $hub2payment,
        Hub2Verification $hub2verification
    ) {
        $this->hub2authentication = $hub2authentication;
        $this->hub2payment = $hub2payment;
        $this->hub2verification = $hub2verification;
    }

    /**
     * Execute the payment process.
     *
     * @param array $paymentData
     * @return array
     */
    public function execute(array $paymentData): array
    {
        try {
            // Vérification des données requises
            $required = ['transaction_id', 'amount', 'currency', 'country', 'provider', 'phoneNumber'];
            foreach ($required as $key) {
                if (empty($paymentData[$key] ?? null)) {
                    return [
                        'status' => 'error',
                        'message' => "Champ manquant: {$key}",
                        'transactions_id' => $paymentData['transaction_id'] ?? null,
                    ];
                }
            }

            // Récupérer la transaction existante
            $transaction = Transaction::where('transaction_id', $paymentData['transaction_id'])->first();
            if (! $transaction) {
                return [
                    'status' => 'error',
                    'message' => 'Transaction introuvable',
                    'transactions_id' => $paymentData['transaction_id'],
                ];
            }

            DB::beginTransaction();

            // Authentification
            $authParams = [
                'customerReference' => $paymentData['transaction_id'],
                'purchaseReference' => 'ORD98' . date('YmdHis'),
                'amount' => $paymentData['amount'],
                'currency' => $paymentData['currency'],
                'apiKey' => config('sdkpayment.HUB2_API_KEY'),
                'merchantId' => config('sdkpayment.HUB2_MERCHANT_ID'),
                'environment' => config('sdkpayment.HUB2_ENVIRONMENT'),
            ];
            $authResponse = $this->hub2authentication->authenticate($authParams);

            $token = $authResponse['token'] ?? null;
            $id = $authResponse['id'] ?? null;
            if (! $token || ! $id) {
                throw new \RuntimeException('Réponse d\'authentification invalide');
            }

            // Exécution du paiement
            $paymentParams = [
                'token' => $token,
                'id' => $id,
                'paymentMethod' => 'mobile_money',
                'country' => $paymentData['country'],
                'provider' => $paymentData['provider'],
                'phoneNumber' => $paymentData['phoneNumber'],
                'otpCode' => $paymentData['otpCode'],
            ];
            $paymentResponse = $this->hub2payment->executePayment($paymentParams);

            $pay_id = $paymentResponse['payment']['payment_id'] ?? null;
            if (! $pay_id) {
                throw new \RuntimeException('Aucun payment_id retourné par le provider');
            }

            // Mise à jour initiale
            $transaction->response_init_payment = is_array($paymentResponse) ? json_encode($paymentResponse) : $paymentResponse;
            $transaction->transaction_id_partner = $pay_id;
            $transaction->status = 'processing';
            $transaction->comment = 'Payment initiated';
            $transaction->save();

            // Vérification du statut du paiement
            $verificationParams = [
                'pay_id' => $pay_id,
                'apiKey' => config('sdkpayment.HUB2_API_KEY'),
                'merchantId' => config('sdkpayment.HUB2_MERCHANT_ID'),
                'environment' => config('sdkpayment.HUB2_ENVIRONMENT'),
            ];
            $verificationResponse = $this->hub2verification->executeVerification($verificationParams);

            $status = $verificationResponse['status'] ?? null;
            if ($status === 'success') {
                $tr_status = 'completed';
                $comment = 'Payment successful';
            } elseif ($status === 'failed') {
                $tr_status = 'failed';
                $comment = 'Payment failed';
            } elseif ($status === 'pending') {
                $tr_status = 'pending';
                $comment = 'Payment pending';
            } else {
                $tr_status = 'processing';
                $comment = 'Payment processing';
            }

            // Mise à jour finale
            $transaction = Transaction::where('transaction_id_partner', $pay_id)->first() ?? $transaction;
            $transaction->response_check_payment = is_array($verificationResponse) ? json_encode($verificationResponse) : $verificationResponse;
            $transaction->status = $tr_status;
            $transaction->comment = $comment;
            $transaction->save();

            DB::commit();

            return [
                'status' => $tr_status,
                'message' => $comment,
                'transactions_id' => $paymentData['transaction_id'],
                'api_processing' => 'Détails du traitement API',
                'api_response' => $verificationResponse,
            ];
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Erreur lors du traitement de la transaction hub2', [
                'error' => $e->getMessage(),
                'transaction' => $paymentData['transaction_id'] ?? null,
            ]);

            return [
                'status' => 'error',
                'message' => 'Erreur lors du traitement de la transaction hub2: ' . $e->getMessage(),
                'transactions_id' => $paymentData['transaction_id'] ?? null,
            ];
        }
    }
}
