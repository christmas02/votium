<?php

namespace App\Repository;

use App\Models\Transaction;

class TransactionRepository
{
    public function createTransaction($dataTransaction): bool
    {
        try {
            $transaction = new Transaction();
            $transaction->transactions_id = $dataTransaction['transactions_id'];
            $transaction->votes_id = $dataTransaction['votes_id'];
            $transaction->payment_method = $dataTransaction['payment_method'];
            $transaction->currency = $dataTransaction['currency'];
            $transaction->montant_payee = $dataTransaction['montant_payee'];
            $transaction->status = $dataTransaction['status'];
            $transaction->transaction_date = $dataTransaction['transaction_date'];
            $transaction->telephone = $dataTransaction['telephone'];
            $transaction->api_processing = $dataTransaction['api_processing'];
            $transaction->api_response = $dataTransaction['api_response'];
            $transaction->commentaire = $dataTransaction['commentaire'];
            $transaction->date_transaction = $dataTransaction['date_transaction'];
            $transaction->date_processing = $dataTransaction['date_processing'];

            $transaction->save();
            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la sauvegarde de la transaction : ' . $e->getMessage());
            return false;
        }
    }

    public function updateTransactionStatus($dataTransaction): bool
    {
        try {
            $transaction = Transaction::where('transactions_id', $dataTransaction['transactions_id'])->first();
            // TO DO UPDATE TRANSACTION STATUS
            $transaction->status = $dataTransaction['status'];

            $transaction->save();
            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour du statut de la transaction : ' . $e->getMessage());
            return false;
        }
    }

    public function update($dataTransaction): bool
    {
        try {
            $transaction = Transaction::where('transactions_id', $dataTransaction['transactions_id'])->first();
            // TO DO UPDATE TRANSACTION INFO
            $transaction->votes_id = $dataTransaction['votes_id'];
            $transaction->payment_method = $dataTransaction['payment_method'];
            $transaction->currency = $dataTransaction['currency'];
            $transaction->montant_payee = $dataTransaction['montant_payee'];
            $transaction->status = $dataTransaction['status'];
            $transaction->transaction_date = $dataTransaction['transaction_date'];
            $transaction->telephone = $dataTransaction['telephone'];
            $transaction->api_processing = $dataTransaction['api_processing'];
            $transaction->api_response = $dataTransaction['api_response'];
            $transaction->commentaire = $dataTransaction['commentaire'];
            $transaction->date_transaction = $dataTransaction['date_transaction'];
            $transaction->date_processing = $dataTransaction['date_processing'];

            $transaction->save();
            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour de la transaction : ' . $e->getMessage());
            return false;
        }
    }
}
