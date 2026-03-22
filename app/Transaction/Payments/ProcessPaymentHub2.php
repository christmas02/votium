<?php

namespace App\Transaction\Payments;

use App\Models\Transaction;
use App\Sdkpayment\Hub2\Hub2authenticate;
use App\Sdkpayment\Hub2\Hub2payment;
use App\Sdkpayment\Hub2\Hub2Verification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\WebhookController;
use App\Services\VoteService;
use Throwable;

class ProcessPaymentHub2
{
    protected $hub2authentication;
    protected $hub2payment;
    protected $hub2verification;
    protected $voteService;
    protected $webhookController;

    public function __construct(
        Hub2authenticate $hub2authentication,
        Hub2payment $hub2payment,
        Hub2Verification $hub2verification,
        VoteService $voteService,
        WebhookController $webhookController
    ) {
        $this->hub2authentication = $hub2authentication;
        $this->hub2payment = $hub2payment;
        $this->hub2verification = $hub2verification;
        $this->voteService = $voteService;
        $this->webhookController = $webhookController;
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
            $transaction->api_processing = 'Hub2';
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
            logger()->info('Hub2 response after authenticate ', [$authResponse]);

            $token = $authResponse['token'] ?? null;
            $id = $authResponse['id'] ?? null;
            if (! $token || ! $id) {
                throw new \RuntimeException('Réponse d\'authentification invalide');
            }
            
            // format name provider
            if ($paymentData['provider'] === 'orange_money') {
                $provider = 'orange';
            } else {
                $provider = $paymentData['provider'];
            }

            // Exécution du paiement
            $paymentParams = [
                'token' => $token,
                'id' => $id,
                'paymentMethod' => 'mobile_money',
                'country' => $paymentData['country'],
                'provider' => $provider,
                'phoneNumber' => $paymentData['phoneNumber'],
                'otpCode' => $paymentData['otpCode'],
            ];
            $paymentResponse = $this->hub2payment->executePayment($paymentParams);
            logger()->info('Hub2 response after payment execute ', [$paymentResponse]);


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
            logger()->info('Hub2 response after verification state ', [$verificationResponse]);


            $status = $verificationResponse['status'] ?? null;
            if ($status === 'successful') {
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

            logger()->info('Hub2 response final ', [
                'status' => $tr_status,
                'message' => $comment,
                'transactions_id' => $transaction['transaction_id'],
                'api_response' => $verificationResponse,
            ]);
            
            return [
                'status' => $tr_status,
                'message' => $comment,
                'transactions_id' => $transaction['transaction_id'],
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

    public function executeCheckStatua($transactionId)
    {
        try {
            logger()->info('Hub2 use methode verification state transaction ', ['transactions_id' => $transactionId]);
            // recupreation de la transaction
            $transaction = Transaction::where('transaction_id', $transactionId)->first();
            if (! $transaction) {
                Log::warning('hub2 methode verification : transaction not found', ['transactions_id' => $transactionId]);
                return [
                    'status' => 'error',
                    'message' => 'Transaction introuvable',
                    'transactions_id' => $transactionId,
                ];
            }

            // Vérification du statut du paiement
            $verificationParams = [
                'pay_id' => $transaction->transaction_id_partner,
                'apiKey' => config('sdkpayment.HUB2_API_KEY'),
                'merchantId' => config('sdkpayment.HUB2_MERCHANT_ID'),
                'environment' => config('sdkpayment.HUB2_ENVIRONMENT'),
            ];
            $verificationResponse = $this->hub2verification->executeVerification($verificationParams);
            logger()->info('Hub2 response after verification state ', $verificationResponse);

            // Mise à jour des champs s'ils sont fournis
            $status = $verificationResponse['status'] ?? null;
            switch ($status) {
                case 'approved':
                case 'successful':
                case 'success':
                case 'completed':
                    $tr_status = 'completed';
                    $comment = 'Payment successful';
                    break;

                case 'pending':
                case 'processing':
                    $tr_status = 'pending';
                    $comment = 'Payment pending';
                    break;

                case 'failed':
                case 'error':
                    $tr_status = 'failed';
                    $comment = 'Payment failed';
                    break;

                default:
                    $tr_status = 'processing';
                    $comment = 'Payment processing';
                    break;
            }

            // Mise à jour finale
            if ($transaction) {
                $transaction->response_check_payment = is_array($verificationResponse) ? json_encode($verificationResponse) : $verificationResponse;
                $transaction->status = $tr_status;
                $transaction->comment = $comment;
                $transaction->save();
            }

            logger()->info('Hub2 methode verification response final ', [
                'status' => $tr_status,
                'message' => $comment,
                'transactions_id' => $transaction['transaction_id'] ?? null,
                'api_response' => $verificationResponse,
            ]);

            // Mise a jour de la vote
            $paramVote = [
                'vote_id' => $transaction->vote_id,
                'status' => $transaction->status,
            ];
            $vote = $this->voteService->updateVoteStatusAfterPayment($paramVote);

            // si la transaction est succes generer un recu de paiement
            if (is_object($vote) && $vote->status === 'confirmed') {
                $this->webhookController->generatePdf($vote, $transaction);
            }

            $invoice = $this->voteService->checkStatusTransaction($transactionId);
            return $invoice;

        } catch (Throwable $e) {
            Log::error('Erreur lors du check status de la transaction hub2', [
                'error' => $e->getMessage(),
            ]);

            return [
                'status' => 'error',
                'message' => 'Erreur lors du check status de la transaction hub2: ' . $e->getMessage(),
            ];
        }
    }
}
