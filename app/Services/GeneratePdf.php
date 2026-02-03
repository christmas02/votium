<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Log;

class GeneratePdf
{
    public function generatePaymentReceipt($data)
    {
        try {
            logger()->info('Start generate invoice', $data);

            set_time_limit(120);

            // Créer le dossier s'il n'existe pas
            $directory = public_path('invoices');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true); // ✅ Désactiver les ressources externes
            $options->set('defaultFont', 'Arial');
            $dompdf = new Dompdf($options);

            $html = view('invoice.payment', compact('data'))->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $pdfContent = $dompdf->output();
            $name_file = $data['invoice_number'] . '.pdf';
            $filePath = "{$directory}/{$name_file}";

            file_put_contents($filePath, $pdfContent);
            logger()->info('finish generate invoice', ['file' => $name_file]);

            return $name_file;

        } catch (\Throwable $th) {
            Log::error('Erreur lors de la generation de la facture', ['error' => $th->getMessage()]);
        }
    }
}
