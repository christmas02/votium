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
            $list_withdrawal_account = WithdrawalAccount::where('customer_id', $customer_id)->get();
            return response()->json(['data' => $list_withdrawal_account], 200);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des compte de retrait : ' . $e->getMessage());
            return response()->json(['message' => 'Une erreur est survenue lors de la récupération des comptes de retraits.'], 500);
        }
    }

    public function createRetrait($data)
    {
        try {
            [
                'customer_id' => 'required|string',
                'withdrawal_account_id' => 'required|string',
                'amount' => 'required|numeric',
                'motif' => 'nullable|string',
            ];
            // Récupérer le compte client via customer_id
            $account = Account::where('customer_id', $data['customer_id'])->first();
            if (!$account) {
                log::warning('Compte client non trouvé pour customer_id: ' . $data['customer_id']);
                return response()->json(['message' => 'Compte client non trouvé.'], 404);
            }

            // recuperer les information withdrawal account
            $withdrawalAccount = WithdrawalAccount::where('withdrawal_account_id', $data['withdrawal_account_id'])->first();
            if (!$withdrawalAccount) {
                log::warning('Compte de retrait non trouvé pour withdrawal_account_id: ' . $data['withdrawal_account_id']);
                return response()->json(['message' => 'Compte de retrait non trouvé.'], 404);
            }

            $paymentMethod = $withdrawalAccount->payment_method;
            $telephone = $withdrawalAccount->telephone;

            // Vérifier que la balance est suffisante
            $amount = (float) $data['amount'];
            if ($account->balance < $amount) {
                logger()->warning('Balance insuffisante pour le retrait - customer_id: ' . $data['customer_id'] . ', balance: ' . $account->balance . ', montant demandé: ' . $amount);
                throw new \Exception('Balance insuffisante pour effectuer ce retrait.');
                return response()->json([
                    'message' => 'Balance insuffisante pour effectuer ce retrait.',
                    'balance_disponible' => $account->balance,
                    'montant_demande' => $amount
                ], 422);
            }

            $transactionRetrait = new TransactionRetrait();
            $transactionRetrait->transactions_retrait_id = (string) \Str::uuid();
            $transactionRetrait->withdrawal_account_id = $data['withdrawal_account_id'];
            $transactionRetrait->montant_payee = $data['amount'];
            $transactionRetrait->payment_method = $paymentMethod;
            $transactionRetrait->currency = 'XOF';
            $transactionRetrait->telephone = $telephone;
            $transactionRetrait->api_processing =  null;
            $transactionRetrait->api_response =  null;
            $transactionRetrait->commentaire = null;
            $transactionRetrait->status = 'created';
            $transactionRetrait->date_transaction = now();
            $transactionRetrait->save();

            // appel du service de retrait externe (ex: PayDunya) et mise à jour du statut en fonction de la réponse
           
            return [
                'status' => 'created',
                'message' => $comment ?? 'Retrait créé avec succès.',
                'transactions_id' => $transactionRetrait['transactions_retrait_id'],
                'api_response' => $verificationResponse ?? null,
            ];
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