<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Services\LedgerServicePayment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessLedgerTransactionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Nombre de tentatives avant abandon.
     */
    public int $tries = 3;

    /**
     * Délai entre les tentatives en secondes (backoff exponentiel).
     */
    public array $backoff = [60, 300, 600];

    /**
     * Timeout du job en secondes.
     */
    public int $timeout = 120;

    public function __construct()
    {
        $this->onQueue('ledger');
    }

    public function handle(LedgerServicePayment $ledgerService): void
    {
        Log::info('[ProcessLedgerTransactionsJob] Démarrage du traitement des transactions comptables.');

        $processed = 0;
        $failed    = 0;

        Transaction::where('status', 'completed')
            ->where('is_ecriture_comptable', 0)
            ->cursor()
            ->each(function (Transaction $transaction) use ($ledgerService, &$processed, &$failed) {
                try {
                    $ledgerService->processTransaction($transaction);
                    $processed++;
                } catch (Throwable $e) {
                    $failed++;
                    Log::error('[ProcessLedgerTransactionsJob] Erreur sur la transaction', [
                        'transaction_id' => $transaction->transaction_id,
                        'error'          => $e->getMessage(),
                        'trace'          => $e->getTraceAsString(),
                    ]);
                    // On continue les autres transactions plutôt que de bloquer tout le job
                }
            });

        Log::info('[ProcessLedgerTransactionsJob] Traitement terminé.', [
            'processed' => $processed,
            'failed'    => $failed,
        ]);
    }

    /**
     * Gestion de l'échec définitif du job (après épuisement des tentatives).
     */
    public function failed(Throwable $exception): void
    {
        Log::critical('[ProcessLedgerTransactionsJob] Job définitivement échoué.', [
            'error' => $exception->getMessage(),
        ]);
    }
}
