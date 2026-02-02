<?php

namespace App\Repository;

use App\Models\Invoice;
use App\Models\Transaction;

class TransactionRepository
{
    public function getTransactionByid($transactionId)
    {
        return Transaction::where('transaction_id', $transactionId)->first();
    }

    public function createTransaction($dataTransaction): bool
    {
        try {
            $transaction = new Transaction();
            $transaction->transaction_id = $dataTransaction['transaction_id'];
            $transaction->vote_id = $dataTransaction['vote_id'];
            $transaction->payment_method = $dataTransaction['provider'];
            $transaction->currency = $dataTransaction['currency'];
            $transaction->country = $dataTransaction['country'];
            $transaction->amount_paid = $dataTransaction['amount'];
            $transaction->telephone = $dataTransaction['phoneNumber'];
            $transaction->api_processing = $dataTransaction['api_processing'];
            $transaction->comment = $dataTransaction['comment'];
            $transaction->status = 'created';
            $transaction->date_transaction = now();
            $transaction->date_processing = null;

            $transaction->save();
            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la sauvegarde de la transaction : ' . $e->getMessage());
            return false;
        }
    }


    public function updateTransactionStatus($dataTransaction): bool
    {
        try {
            $transaction = Transaction::where('transactions_id', $dataTransaction['transactions_id'])->first();
            $transaction->status = $dataTransaction['status'];
            $transaction->save();
            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour du statut de la transaction : ' . $e->getMessage());
            return false;
        }
    }

    public function createImvoie($dataInvoice)
    {
        // Implementation for creating invoice
        try {
            // Code to create invoice
            $invoice = new Invoice();
            $invoice->invoice_id = $dataInvoice['invoice_id'];
            $invoice->transaction_id = $dataInvoice['transaction_id'];
            $invoice->invoice_number = $dataInvoice['invoice_number'];
            $invoice->name_file_pdf = null;
            $invoice->link_pdf = null; // to be updated after PDF generation
            $invoice->date_invoice = now();
            $invoice->save();
            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de la facture : ' . $e->getMessage());
            return false;
        }
    }

    public function getInvoiceByTransactionId($transactionId)
    {
        return Invoice::where('transaction_id', $transactionId)->first();
    }

    public function updateLinkeAndNameInvoice($dataInvoice): bool
    {
        try {
            $invoice = Invoice::where('invoice_id', $dataInvoice['invoice_id'])->first();
            $invoice->link_pdf = $dataInvoice['link_pdf'];
            $invoice->name_file_pdf = $dataInvoice['name_file_pdf'];
            $invoice->save();
            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour du lien de la facture : ' . $e->getMessage());
            return false;
        }
    }


}
