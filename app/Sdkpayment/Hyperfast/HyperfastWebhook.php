<?php
namespace App\Sdkpayment\Hyperfast;

use App\Models\Transaction;
use App\Services\GeneratePdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HyperfastWebhook
{
    /**
     * Traite le webhook Hyperfast et met à jour la transaction correspondante.
     *
     * @param array $payload Données reçues du webhook
     * @return array si mise à jour OK, false sinon
     */
    public function handleWebhook(array $payload): array
    {
        try {
            if (empty($payload['id'])) {
                throw new \InvalidArgumentException('Payload missing id');
            }

            $reference = $payload['id'];
            //DB::beginTransaction();
            // Cherche la transaction par plusieurs colonnes possibles
            $transaction = Transaction::where('transaction_id_partner', $reference)->first();

            if (! $transaction) {
                Log::warning('Hyperfast webhook: transaction not found', ['reference' => $reference, 'payload' => $payload]);
                //DB::rollBack();
            }
            // Mise à jour des champs s'ils sont fournis
            $status = $payload['status'] ?? null;
            if ($status === 'success') {
                $tr_status = 'completed';
                $comment = 'Payment successful';
            } elseif ($status === 'failed') {
                $tr_status = 'failed';
                $comment = 'Payment failed';
            } elseif ($status === 'pending') {
                $tr_status = 'pending';
                $comment = 'Payment pending';
            } else {
                $tr_status = 'processing';
                $comment = 'Payment processing';
            }
            if (isset($payload['status'])) {
                $transaction->status = $tr_status;
            }
            $transaction->response_init_payment = is_array($payload) ? json_encode($payload) : $payload;
            $transaction->comment = $comment;
            $transaction->save();

            $response = $transaction->toArray();

            //DB::commit();
            Log::info('Hyperfast webhook: transaction updated', ['id' => $transaction->transaction_id, 'reference' => $reference]);
            return $response;

        } catch (\Throwable $e) {
            //DB::rollBack();
            Log::error('Hyperfast webhook error: ' . $e->getMessage(), ['payload' => $payload]);
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}