<?php

namespace App\Transaction\Payments;

use App\Models\Transaction;
use App\Sdkpayment\Hyperfast\HyperfastAuthenticate;
use App\Sdkpayment\Hyperfast\HyperfastPayment;
use App\Sdkpayment\Hyperfast\HyperfastVerification;
use Illuminate\Support\Facades\DB;

class ProcessPaymentHyperfast
{
    protected $hyperfastAuthenticate;
    protected $hyperfastPayment;
    protected $hyperfastVerification;

    public function __construct(HyperfastAuthenticate $hyperfastAuthenticate, HyperfastPayment $hyperfastPayment,
    HyperfastVerification $hyperfastVerification)
    {
        $this->hyperfastAuthenticate = $hyperfastAuthenticate;
        $this->hyperfastPayment = $hyperfastPayment;
        $this->hyperfastVerification = $hyperfastVerification;

    }

    public function execute($paymentData): array
    {
        try {

            // Récupérer la transaction existante
            $transaction = Transaction::where('transaction_id', $paymentData['transaction_id'])->first();
            if (! $transaction) {
                throw new \RuntimeException('Transaction introuvable');
            }

            // Authenticate with Hyperfast
            $authResponse = $this->hyperfastAuthenticate->authenticate();
            $token = $authResponse['accessToken'];
            if (! $token) {
                throw new \RuntimeException('Réponse d\'authentification invalide');
            }
            // Process the payment
            $paymentParams = [
                'amount' => $paymentData['amount'],
                'phone' => $paymentData['phoneNumber'],
                'metadata' => ['customer' => 'dupont', 'Id_transaction' => $paymentData['transaction_id']],
                'access_token' => $token,
            ];
            $paymentResponse = $this->hyperfastPayment->processPayment($paymentParams);
            logger()->info('Hyperfast response after processPayment', [$paymentResponse]);
            //dd($paymentResponse['transactionId']);
            $reference = $paymentResponse['transactionId']?? null;
            if (! $reference) {
                return [
                    'status' => $paymentResponse['status'],
                    'message' => $paymentResponse['message'],
                ];
            }

            // Mise à jour initiale
            $transaction->response_init_payment = is_array($paymentResponse) ? json_encode($paymentResponse) : $paymentResponse;
            $transaction->transaction_id_partner = $reference;
            $transaction->status = 'processing';
            $transaction->comment = 'Payment initiated';
            $transaction->save();

            if (!$paymentResponse['success']) {
                return [
                    'status' => $paymentResponse['status'],
                    'message' => $paymentResponse['message'],
                ];
                //throw new \RuntimeException('Aucun payment_id retourné par le provider');
            }

            if ($paymentData['provider'] == 'orange') {
                // For Orange, we expect an OTP confirmation step
                $otpParams = [
                    'otp' => $paymentData['otpCode'],
                    'reference' => $paymentResponse['transactionId'],
                    'access_token' => $token,
                ];
                $confirmResponse = $this->hyperfastPayment->confirmPaymentOtp($otpParams);
                logger()->info('Hyperfast response after confirmPaymentOtp', [$paymentResponse]);

                if ($confirmResponse['status'] == 'failed') {
                    // Mise à jour initiale
                    $transaction->response_init_payment = is_array($confirmResponse) ? json_encode($confirmResponse) : $confirmResponse;
                    $transaction->transaction_id_partner = $confirmResponse['transactionId'];
                    $transaction->status = $confirmResponse['status'];
                    $transaction->comment = 'Payment failed';
                    $transaction->save();

                    return [
                        'status' => $confirmResponse['status'],
                        'message' => $confirmResponse['description'],
                    ];
                    //throw new \RuntimeException('Confirmation OTP échouée');
                }elseif ($confirmResponse['status'] == 'pending') {
                    // Mise à jour initiale
                    $transaction->response_init_payment = is_array($confirmResponse) ? json_encode($confirmResponse) : $confirmResponse;
                    $transaction->transaction_id_partner = $confirmResponse['transactionId'];
                    $transaction->status = $confirmResponse['status'];
                    $transaction->comment = 'Payment pending';
                    $transaction->save();

                    return [
                        'status' => $confirmResponse['status'],
                        'message' => $confirmResponse['description'],
                    ];
                    //throw new \RuntimeException('Confirmation OTP échouée');
                }
            }

            // Verification du status de la transaction
            $paramVerification = [
                'transactionId' => $paymentResponse['transactionId'],
                'access_token' => $token,
            ];
            $verificationResponse = $this->hyperfastVerification->processVerification($paramVerification);
            logger()->info('Hyperfast response after processVerification', [$verificationResponse]);


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
            $transaction = Transaction::where('transaction_id_partner', $verificationResponse ['reference'],)->first() ?? $transaction;
            $transaction->response_check_payment = is_array($verificationResponse) ? json_encode($verificationResponse) : $verificationResponse;
            $transaction->status = $tr_status;
            $transaction->comment = $comment;
            $transaction->save();

            return [
                'status' => $tr_status,
                'message' => $comment,
                'transactions_id' => $transaction['transaction_id'],
                'api_response' => $verificationResponse,
            ];

        } catch (\Exception $e) {
            //DB::rollBack();
            \Log::error('Erreur processHyperfast : ' . $e->getMessage());
            return [
                'status' => 'failed',
                'message' => 'Echec du traitement de l operation de payment',
            ];
            //throw new \Exception("Error processing Hyperfast payment: " . $e->getMessage());
        }

    }

}