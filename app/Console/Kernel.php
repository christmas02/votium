<?php

namespace App\Console;

use App\Jobs\ProcessLedgerTransactionsJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Traitement des écritures comptables toutes les 15 minutes
        $schedule->job(new ProcessLedgerTransactionsJob(), 'ledger')
            ->everyFifteenMinutes()
            ->withoutOverlapping()
            ->onFailure(function () {
                \Illuminate\Support\Facades\Log::error('[Scheduler] ProcessLedgerTransactionsJob a échoué.');
            });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
