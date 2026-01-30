<?php

namespace App\Services;

use App\Repository\TransactionRepository;
use App\Repository\VotesRepository;
use App\Transaction\Payments\ProcessPaymentHub2;
use App\Transaction\Payments\ProcessPaymentHyperfast;
use Illuminate\Support\Facades\DB;


class VoteService
{
    protected $voteRepository;
    protected $transactionRepository;
    protected $payment;
    protected $setting;
    protected $paymentHyperfast;

    public function __construct(VotesRepository $voteRepository,
                                TransactionRepository $transactionRepository,
                                ProcessPaymentHub2 $payment, Setting $setting,
                                ProcessPaymentHyperfast $paymentHyperfast)
    {
        // Initialisation des dépendances si nécessaire
        $this->voteRepository = $voteRepository;
        $this->transactionRepository = $transactionRepository;
        $this->payment = $payment;
        $this->setting = $setting;
        $this->paymentHyperfast = $paymentHyperfast;
    }

    /**
     * Traiter un vote avec transaction associée
     */
    public function processVote(array $data)
    {
        try {
            // 1️⃣ Enregistrement du vote
            $vote = $this->voteRepository->save($data);
            if ($vote) {\Log::info('Vote enregistré avec succès pour le vote ID ' . $data['vote_id']);}
            else {
                \Log::error('Erreur lors de la création du vote');
//                return [
//                    'status' => 'error',
//                    'code' => 'VOTE_CREATION_FAILED',
//                    'message' => 'Erreur lors de la création du vote',
//                    'detail' => null
//                ]
                throw new \RuntimeException('Erreur lors de la creation du vote ');;
            }

            // 2️⃣ Création de la transaction liée au vote
            $dataTransaction = [
                // data de la transaction
                'transaction_id' => $this->setting->generateUuid(),
                'vote_id' => $data['vote_id'],
                'provider' => $data['provider'],
                'amount' => $data['amount'],
                'currency' => 'XOF',
                'country' => 'CI',
                'phoneNumber' => $data['phoneNumber'],
                'api_processing' => 'hyperfast',
                'comment' => 'creat payment for vote',
                'otpCode' => $data['otpCode'],
            ];
            $transaction = $this->transactionRepository->createTransaction($dataTransaction);
            if ($transaction) {\Log::info('Transaction créée avec succès pour le vote ID ' . $dataTransaction['transaction_id']);}
            else { throw new \RuntimeException('Erreur lors de la creation du vote ');}

            // 3️⃣ Processing de la transaction (paiement)
            //$resul = $this->payment->execute($dataTransaction);
            $resul = $this->paymentHyperfast->execute($dataTransaction);
//
//           //\Log::info('Transaction traitée avec succès pour le vote ID ' . $resul);
//           // 4️⃣ Mise à jour des status du vote en fonction du résultat du paiement
            //$this->updateVoteStatusAfterPayment($resul);

            return $resul;

        } catch (\Exception $e) {

            \Log::error('Erreur lors du traitement du vote : ' . $e->getMessage());
            throw $e; // Rejeter l'exception pour gestion en amont
        }

    }


    public function updateVoteStatusAfterPayment(array $resul): array
    {
        $transactionId = $resul['transactions_id'] ?? $resul['transaction_id'] ?? null;
        if (! $transactionId) {
            return ['status' => 'error', 'message' => 'transaction_id manquant'];
        }
        try {
            DB::beginTransaction();

            // Récupère la ligne transaction + vote
            $row = DB::table('transactions')
                ->join('votes', 'transactions.vote_id', '=', 'votes.vote_id')
                ->where('transactions.transaction_id', $transactionId)
                ->select('votes.vote_id as vote_id', 'votes.status as vote_status', 'transactions.status as transaction_status')
                ->first();

            if (! $row) {
                DB::rollBack();
                return ['status' => 'error', 'message' => 'Transaction ou vote introuvable', 'transaction_id' => $transactionId];
            }

            // Statut fourni par le résultat du paiement (fallback sur la transaction en base)
            $txStatus = $resul['status'] ?? $row->transaction_status ?? null;

            // Mapping simple des statuts transaction -> statut vote
            $voteStatus = match ($txStatus) {
                'completed', 'valid', 'success' => 'confirmed',
                'failed'    => 'rejected',
                'pending', 'processing' => 'pending',
                default     => 'processing',
            };

            // Mise à jour du vote
            DB::table('votes')
                ->where('vote_id', $row->vote_id)
                ->update([
                    'status' => $voteStatus,
                    'updated_at' => now(),
                ]);

            DB::commit();

            \Log::info('Statut du vote mis à jour après paiement', [
                'transaction_id' => $transactionId,
                'vote_id' => $row->vote_id,
                'new_status' => $voteStatus,
            ]);

            return ['status' => 'ok', 'vote_id' => $row->vote_id, 'vote_status' => $voteStatus];
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Erreur lors de la mise à jour du statut du vote', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            return ['status' => 'error', 'message' => $e->getMessage(), 'transaction_id' => $transactionId];
        }

    }

}