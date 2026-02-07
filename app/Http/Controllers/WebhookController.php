<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Repository\CandidatRepository;
use App\Sdkpayment\Hyperfast\HyperfastWebhook;
use App\Services\GeneratePdf;
use App\Services\Setting;
use App\Services\VoteService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebhookController
{
    protected $hyperfastWebhook;
    protected $voteService;
    protected $setting;
    protected $candidat;

    public function __construct(HyperfastWebhook $hyperfastWebhook, VoteService $voteService, Setting $setting,
                                CandidatRepository $candidat)
    {
        $this->hyperfastWebhook = $hyperfastWebhook;
        $this->voteService = $voteService;
        $this->setting = $setting;
        $this->candidat = $candidat;
    }
    public function handleWebhookHyperfast(Request $request)
    {
        try {
            $response = [
                'id' => $request->id,
                'phone' => $request->phone,
                'carrier' => $request->carrier,
                'amount' => $request->amount,
                'currency' => $request->currency,
                'status' => $request->status,
                'carrier_transaction_id' => $request->carrier_transaction_id,
                'response' => $request->response,
                'syntax' => $request->syntax,
                'metadata' => $request->metadata,
                'created_at' => $request->created_at,
                'processed_at' => $request->processed_at,
            ];
            // Mise a jour de la transaction
            $transaction = $this->hyperfastWebhook->handleWebhook($response);
            logger()->info('Webhook Hyperfast traité pour la transaction ID ' . $transaction['transaction_id']);
            // Mise a jour de la vote
            $paramVote = [
                'vote_id' => $transaction['vote_id'],
                'status' => $transaction['status'],
            ];
            $vote = $this->voteService->updateVoteStatusAfterPayment($paramVote);
            // si la transaction est succes generer un recu de paiement
            if ($vote->status === 'confirmed') {
                // save invoice data
                $invoice_number = 'VOTIYM' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $invoice_id = $this->setting->generateUuid();
                $dataInvoice = [
                    'invoice_id' => $invoice_id,
                    'transaction_id' => $transaction['transaction_id'],
                    'invoice_number' => $invoice_number
                ];
                $this->voteService->saveInvoiceAfterPayment($dataInvoice);
                // Génération du PDF de reçu de paiement
                $vote->candidat_id;
                $candidat = $this->candidat->getCandidat($vote->candidat_id) ;
                $pdfGenerator = new GeneratePdf();
                $pdfData = [
                    'transaction_id' => $transaction['transaction_id'],
                    'invoice_number' => $invoice_number,
                    'reference' => $transaction['transaction_id_partner'],
                    'date' => Carbon::now()->format('d/m/Y H:i:s'),
                    'date_transaction' => Carbon::now()->format('d/m/Y H:i:s'),
                    'phoneNumber' => $transaction['telephone'],
                    'name' => $vote->name,
                    'email' => $vote->email,
                    'quantity' => $vote->quantity,
                    'amount' => $transaction['amount_paid'],
                    'candidat' => $candidat->name,
                ];
                $invoice_name = $pdfGenerator->generatePaymentReceipt($pdfData);
                $link_pdf = rtrim(env('INVOICE_PATH'), '/') . '/' . $invoice_name;
                $invoiceInfoData = [
                    'invoice_id' => $invoice_id,
                    'link_pdf' => $link_pdf,
                    'name_file_pdf' => $invoice_name,
                ];
                $this->voteService->updateLinkInvoiceAfterGeneratePdf($invoiceInfoData);
            }

            return 'operation effectuere avec succes';

        } catch (\Exception $e) {
            \Log::error('Erreur webhookController handleWebhookHyperfast : ' . $e->getMessage());
            throw $e; // Rejeter l'exception pour gestion en amont
        }
    }
}