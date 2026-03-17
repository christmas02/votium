<?php

namespace App\Services;

use App\Models\Account;
use App\Models\ApiProcessing;
use App\Models\Campagne;
use App\Models\LedgerEntry;
use App\Models\Transaction;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LedgerServicePayment
{
    /**
     * Traite une transaction complétée et génère les écritures ledger.
     * Le traitement est idempotent : si des écritures existent déjà pour
     * cette transaction, elles ne sont pas recréées.
     */
    public function processTransaction(Transaction $transaction): void
    {
        // Idempotency guard — ne jamais retraiter une transaction déjà comptabilisée
        if ((int) $transaction->is_ecriture_comptable === 1) {
            Log::info("[LedgerService] Transaction déjà comptabilisée, ignorée.", [
                'transaction_id' => $transaction->transaction_id,
            ]);
            return;
        }

        DB::transaction(function () use ($transaction) {

            // 1. Récupérer la chaîne vote → campagne → customer → account
            $vote = Vote::where('vote_id', $transaction->vote_id)->firstOrFail();
            $campagne = Campagne::where('campagne_id', $vote->campagne_id)->firstOrFail();
            $account = Account::where('customer_id', $campagne->customer_id)->firstOrFail();

            // 2. Récupérer le taux du partenaire de paiement
            // On matche uniquement sur `name` car le champ payment_method
            // peut avoir des conventions différentes entre transactions et api_processing
            $apiProcessing = ApiProcessing::where('name', $transaction->api_processing)
                ->where('type_operation', 'payment')
                ->firstOrFail();

            // 3. Calcul des montants
            // Les taux sont stockés en pourcentage entier (ex: 30 = 30%, 3 = 3%)
            $amountPaid     = (float) $transaction->amount_paid;
            $processingRate = (float) $apiProcessing->processing_rate / 100;
            $billingRate    = (float) $account->billing_rate / 100;

            $processingAmount      = round($amountPaid * $processingRate, 2);
            $amountAfterProcessing = round($amountPaid - $processingAmount, 2);
            $customerAmount        = round($amountPaid - ($amountPaid * $billingRate),2);
            $platformAmount        = round($amountAfterProcessing - $customerAmount, 2);

            Log::info("[LedgerService] Calcul des montants", [
                'transaction_id'        => $transaction->transaction_id,
                'amount_paid'           => $amountPaid,
                'processing_rate'       => $processingRate,
                'billing_rate'          => $billingRate,
                'processing_amount'     => $processingAmount,
                'customer_amount'       => $customerAmount,
                'platform_amount'       => $platformAmount,
            ]);

            // 4. Créer les 3 écritures ledger
            // Écriture 1 : Commission partenaire
            LedgerEntry::create([
                'transaction_id' => $transaction->transaction_id,
                'account_type'   => LedgerEntry::ACCOUNT_PROCESSING_PARTNER,
                'account_id'     => null,
                'entry_type'     => LedgerEntry::TYPE_PROCESSING_FEE,
                'amount'         => $processingAmount,
                'description'    => "Commission partenaire {$transaction->api_processing} — {$transaction->payment_method}",
            ]);

            Log::info("[LedgerService] Écriture processing_fee créée", [
                'transaction_id' => $transaction->transaction_id,
                'amount'         => $processingAmount,
            ]);

            // Écriture 2 : Crédit client
            LedgerEntry::create([
                'transaction_id' => $transaction->transaction_id,
                'account_type'   => LedgerEntry::ACCOUNT_CUSTOMER,
                'account_id'     => $account->account_id,
                'entry_type'     => LedgerEntry::TYPE_CUSTOMER_CREDIT,
                'amount'         => $customerAmount,
                'description'    => "Crédit client — campagne {$campagne->campagne_id}",
            ]);

            Log::info("[LedgerService] Écriture customer_credit créée", [
                'transaction_id' => $transaction->transaction_id,
                'account_id'     => $account->account_id,
                'amount'         => $customerAmount,
            ]);

            // Écriture 3 : Revenu plateforme
            LedgerEntry::create([
                'transaction_id' => $transaction->transaction_id,
                'account_type'   => LedgerEntry::ACCOUNT_PLATFORM,
                'account_id'     => null,
                'entry_type'     => LedgerEntry::TYPE_PLATFORM_REVENUE,
                'amount'         => $platformAmount,
                'description'    => "Revenu Votium — campagne {$campagne->campagne_id}",
            ]);

            Log::info("[LedgerService] Écriture platform_revenue créée", [
                'transaction_id' => $transaction->transaction_id,
                'amount'         => $platformAmount,
            ]);

            // 5. Mettre à jour la balance du compte client
            Account::where('account_id', $account->account_id)
                ->increment('balance', $customerAmount);

            Log::info("[LedgerService] Balance client mise à jour", [
                'account_id'     => $account->account_id,
                'added_amount'   => $customerAmount,
            ]);

            // 6. Marquer la transaction comme comptabilisée
            $transaction->update(['is_ecriture_comptable' => 1]);

            Log::info("[LedgerService] Transaction marquée comptabilisée", [
                'transaction_id' => $transaction->transaction_id,
            ]);
        });
    }
}
