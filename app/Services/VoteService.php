<?php

namespace App\Services;

use App\Repository\TransactionRepository;
use App\Repository\VotesRepository;
use App\Transactions\Payment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class VoteService
{
    protected $voteRepository;
    protected $transactionRepository;
    protected $payment;
    protected $setting;

    public function __construct(VotesRepository $voteRepository,
                                TransactionRepository $transactionRepository,
                                Payment $payment, Setting $setting)
    {
        // Initialisation des dépendances si nécessaire
        $this->voteRepository = $voteRepository;
        $this->transactionRepository = $transactionRepository;
        $this->payment = $payment;
        $this->setting = $setting;
    }

    /**
     * Traiter un vote avec transaction associée
     */
    public function processVote(array $data)
    {
        try {
            $dtata = [
                'vote_id' => $data['vote_id'],
                'payment_method' => $data['payment_method'],
                'montant_payee' => $data['amount'],
                'telephone' => $data['telephone'],
            ];


            // 1️⃣ Enregistrement du vote
            $this->voteRepository->save($data);
            \Log::info('Vote enregistré avec succès pour le vote ID ' . $data['vote_id']);

            // 2️⃣ Création de la transaction liée au vote
            $dataTransaction = [
                'transactions_id' => $this->setting->generateUuid(),
                'vote_id' => $data['vote_id'],
                'payment_method' => $data['payment_method'],
                'montant_payee' => $data['amount'],
                'currency' => 'XOF',
                'telephone' => $data['telephone'],
                'api_processing' => '',
                'api_response' => '',
                'status' => 'INITIATED',
                'commentaire' => 'Transaction pour le vote ID ' . $data['vote_id'],
                'date_transaction' => now(),
                'date_processing' => null,
            ];
            $this->transactionRepository->createTransaction($dataTransaction);
            \Log::info('Transaction créée avec succès pour le vote ID ' . $data['transaction_id']);


            // 3️⃣ Processing de la transaction (paiement)
            $resul = $this->payment->processTransaction($dataTransaction);
            $dataResul = [
                'transactions_id' => $resul['transaction_id'],
                'vote_id' => $data['vote_id'],
                'status' => $resul['status'],
            ];
            \Log::info('Transaction traitée avec succès pour le vote ID ' . $resul);

            // 4️⃣ Mise à jour des statuts
            $this->voteRepository->updateVoteStatus($dataResul);
            $this->transactionRepository->updateTransactionStatus($dataResul);

            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors du traitement du vote : ' . $e->getMessage());
            throw $e; // Rejeter l'exception pour gestion en amont
        }

    }

}