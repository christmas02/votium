<?php

namespace App\Console\Commands;

use App\Models\LedgerEntry;
use App\Models\Transaction;
use App\Services\LedgerServicePayment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestLedgerCommand extends Command
{
    protected $signature = 'ledger:test {--reset : Reset les écritures et les balances avant le test}';
    protected $description = 'Teste le service LedgerServicePayment sur les transactions en attente';

    public function handle(LedgerServicePayment $service): int
    {
        if ($this->option('reset')) {
            $this->resetData();
        }

        $transactions = Transaction::where('status', 'completed')
            ->where('is_ecriture_comptable', 0)
            ->get();

        if ($transactions->isEmpty()) {
            $this->warn('Aucune transaction à traiter (toutes déjà comptabilisées). Utilise --reset pour réinitialiser.');
            return 0;
        }

        $this->info("Transactions à traiter : {$transactions->count()}");
        $this->newLine();

        $processed = 0;
        $failed    = 0;

        foreach ($transactions as $transaction) {
            try {
                $this->line("→ Transaction {$transaction->transaction_id} | montant: {$transaction->amount_paid}");
                $service->processTransaction($transaction);
                $this->info("  ✓ Comptabilisée");
                $processed++;
            } catch (\Throwable $e) {
                $this->error("  ✗ Erreur : " . $e->getMessage());
                $failed++;
            }
        }

        $this->newLine();
        $this->info("Traitées : {$processed} | Échouées : {$failed}");
        $this->info('ledger_entries total : ' . LedgerEntry::count());

        $this->newLine();
        $this->table(
            ['entry_type', 'account_type', 'amount'],
            DB::table('ledger_entries')
                ->select('entry_type', 'account_type', 'amount')
                ->orderBy('created_at')
                ->get()
                ->map(fn($e) => [$e->entry_type, $e->account_type, $e->amount])
                ->toArray()
        );

        $this->newLine();
        $this->table(
            ['account_id', 'customer_id', 'billing_rate', 'balance'],
            DB::table('accounts')
                ->select('account_id', 'customer_id', 'billing_rate', 'balance')
                ->get()
                ->map(fn($a) => [substr($a->account_id, 0, 8).'...', substr($a->customer_id, 0, 8).'...', $a->billing_rate.'%', $a->balance])
                ->toArray()
        );

        return 0;
    }

    private function resetData(): void
    {
        $this->warn('Reset des données de test...');

        DB::table('ledger_entries')->truncate();
        DB::table('accounts')->update(['balance' => 0]);
        DB::table('transactions')
            ->where('status', 'completed')
            ->update(['is_ecriture_comptable' => 0]);

        $this->info('Reset effectué — ledger_entries vidé, balances à 0, transactions remises à is_ecriture_comptable=0');
        $this->newLine();
    }
}
