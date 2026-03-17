<?php

namespace App\Services;

use App\Models\Account;
use App\Models\WithdrawalAccount;
use App\Models\TransactionRetrait;

class RetraitService
{
    public function listWithdrawalAccount($customer_id)
    {
        try {
            $list_withdrawal_account = WithdrawalAccount::where('customer_id', $customer_id)->first();
            return response()->json(['data' => $list_withdrawal_account], 200);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des compte de retrait : ' . $e->getMessage());
            return response()->json(['message' => 'Une erreur est survenue lors de la récupération des comptes de retraits.'], 500);
        }
    }
    
    public function createRetrait($data)
    {
        try {
            // Récupérer le compte client via customer_id
            $account = Account::where('customer_id', $data['customer_id'])->first();
            if (!$account) {
                return response()->json(['message' => 'Compte client non trouvé.'], 404);
            }

            // Vérifier que la balance est suffisante
            $amount = (float) $data['amount'];
            if ($account->balance < $amount) {
                return response()->json([
                    'message' => 'Balance insuffisante pour effectuer ce retrait.',
                    'balance_disponible' => $account->balance,
                    'montant_demande' => $amount
                ], 422);
            }

            $transactionRetrait = new TransactionRetrait();
            $transactionRetrait->transactions_retrait_id = (string) \Str::uuid();
            $transactionRetrait->withdrawal_account_id = $data['withdrawal_account_id'];
            $transactionRetrait->amount = $data['amount'];
            $transactionRetrait->payment_method = $data['payment_method'];
            $transactionRetrait->montant_payee = $data['montant_payee'];
            $transactionRetrait->currency = $data['currency'];
            $transactionRetrait->telephone = $data['telephone'];
            $transactionRetrait->api_processing = $data['api_processing'];
            $transactionRetrait->api_response = $data['api_response'] ?? null;
            $transactionRetrait->commentaire = $data['commentaire'];
            $transactionRetrait->status = 'created';
            $transactionRetrait->date_transaction = now();
            $transactionRetrait->save();

            // appel du service de retrait externe (ex: PayDunya) et mise à jour du statut en fonction de la réponse
           
            return response()->json(['message' => 'Retrait créé avec succès.', 'retrait' => $transactionRetrait], 201);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création du retrait : ' . $e->getMessage());
            return response()->json(['message' => 'Une erreur est survenue lors de la création du retrait.'], 500);
        }
    }
    
    public function listeRetraitByCustomer($customer_id)
    {
        try {
            $withdrawal_accounts = WithdrawalAccount::where('customer_id', $customer_id)->get();

            if ($withdrawal_accounts->isEmpty()) {
                return response()->json(['message' => 'Aucun compte de retrait trouvé pour ce client.'], 404);
            }

            $transactions = [];
            foreach ($withdrawal_accounts as $account) {
                $account_transactions = TransactionRetrait::where('withdrawal_account_id', $account->withdrawal_account_id)->get();
                $transactions = array_merge($transactions, $account_transactions->toArray());
            }

            return response()->json(['data' => $transactions], 200);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des retraits : ' . $e->getMessage());
            return response()->json(['message' => 'Une erreur est survenue lors de la récupération des retraits.'], 500);
        }
    }
    
    
    
}  