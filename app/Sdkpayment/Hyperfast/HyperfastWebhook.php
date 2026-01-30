<?php
namespace App\Sdkpayment\Hyperfast;

use App\Models\Transaction;
use App\Models\Vote;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HyperfastWebhook
{
    /**
     * Traite le webhook Hyperfast et met à jour la transaction correspondante.
     *
     * @param array $payload Données reçues du webhook
     * @return bool true si mise à jour OK, false sinon
     */
    public function handleWebhook(array $payload): bool
    {
        try {
            if (empty($payload['id'])) {
                throw new \InvalidArgumentException('Payload missing id');
            }

            $reference = $payload['id'];

            DB::beginTransaction();

            // Cherche la transaction par plusieurs colonnes possibles
            $transaction = Transaction::where('transaction_id_partner', $reference)->first();

            if (! $transaction) {
                Log::warning('Hyperfast webhook: transaction not found', ['reference' => $reference, 'payload' => $payload]);
                DB::rollBack();
                return false;
            }

            // Mise à jour des champs s'ils sont fournis
            if (isset($payload['status'])) {
                $transaction->status = $payload['status'];
            }

            $transaction->response_init_payment = is_array($payload) ? json_encode($payload) : $payload;

            if (! empty($payload['processed_at'])) {
                $transaction->processed_at = Carbon::parse($payload['processed_at']);
            }

            $transaction->save();

            // mettre a jour le vote
            // Statut fourni par le résultat du paiement (fallback sur la transaction en base)
            $txStatus = $payload['status'] ?? null;

            // Mapping simple des statuts transaction -> statut vote
            $voteStatus = match ($txStatus) {
                'completed', 'valid', 'success' => 'confirmed',
                'failed'    => 'rejected',
                'pending', 'processing' => 'pending',
                default     => 'processing',
            };
            $vote = Vote::where('vote_id',$transaction['vote_id'])->first();
            $vote->status = $voteStatus;
            $vote->save();

            DB::commit();
            Log::info('Hyperfast webhook: transaction updated', ['id' => $transaction->id, 'reference' => $reference]);
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Hyperfast webhook error: ' . $e->getMessage(), ['payload' => $payload]);
            return false;
        }
    }
}