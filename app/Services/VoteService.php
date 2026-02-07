<?php

namespace App\Services;

use App\Repository\TransactionRepository;
use App\Repository\VotesRepository;
use App\Transaction\Payments\ProcessPaymentHub2;
use App\Transaction\Payments\ProcessPaymentHyperfast;
use Illuminate\Support\Facades\DB;


class VoteService
{
    protected $voteRepository;
    protected $transactionRepository;
    protected $payment;
    protected $setting;
    protected $paymentHyperfast;

    public function __construct(VotesRepository $voteRepository,
                                TransactionRepository $transactionRepository,
                                ProcessPaymentHub2 $payment, Setting $setting,
                                ProcessPaymentHyperfast $paymentHyperfast){
        // Initialisation des dépendances si nécessaire
        $this->voteRepository = $voteRepository;
        $this->transactionRepository = $transactionRepository;
        $this->payment = $payment;
        $this->setting = $setting;
        $this->paymentHyperfast = $paymentHyperfast;
    }

    /**
     * Traiter un vote avec transaction associée
     */
    public function processVote(array $data)
    {
        try {
            // 1️⃣ Enregistrement du vote
            $vote = $this->voteRepository->save($data);
            if ($vote) {\Log::info('Vote enregistré avec succès pour le vote ID ' . $data['vote_id']);}
            else {
                \Log::error('Erreur lors de la création du vote');
//                return [
//                    'status' => 'error',
//                    'code' => 'VOTE_CREATION_FAILED',
//                    'message' => 'Erreur lors de la création du vote',
//                    'detail' => null
//                ]
                throw new \RuntimeException('Erreur lors de la creation du vote ');;
            }

            // 2️⃣ Création de la transaction liée au vote
            $dataTransaction = [
                // data de la transaction
                'transaction_id' => $this->setting->generateUuid(),
                'vote_id' => $data['vote_id'],
                'provider' => $data['provider'],
                'amount' => $data['amount'],
                'currency' => 'XOF',
                'country' => 'CI',
                'phoneNumber' => $data['phoneNumber'],
                'api_processing' => 'hyperfast',
                'comment' => 'creat payment for vote',
                'otpCode' => $data['otpCode'],
            ];
            $transaction = $this->transactionRepository->createTransaction($dataTransaction);
            if ($transaction) {\Log::info('Transaction créée avec succès pour le vote ID ' . $dataTransaction['transaction_id']);}
            else { throw new \RuntimeException('Erreur lors de la creation du vote ');}

            // 3️⃣ Processing de la transaction (paiement)
            //$resul = $this->payment->execute($dataTransaction);
            $resul = $this->paymentHyperfast->execute($dataTransaction);

            return $resul;

        } catch (\Exception $e) {
            \Log::error('Erreur lors du traitement du vote : ' . $e->getMessage());
            return [
                'status' => 'error',
                'code' => 'EXCEPTION',
                'message' => 'Erreur interne lors du traitement',
                'detail' => $e->getMessage()
            ];
        }
    }

    public function infoVoteAndTransaction($voteId, $transactionId)
    {
        try {
            $vote = $this->voteRepository->getVote($voteId);
            $transaction = $this->transactionRepository->getTransactionByid($transactionId);

            return [
                'vote' => $vote,
                'transaction' => $transaction,
            ];

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des informations du vote et de la transaction : ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

    }
    

    public function checkStatusTransaction($transactionId): array
    {
        try {
            $resul = $this->transactionRepository->getTransactionByid($transactionId);
            if ($resul->status === 'completed') {
                // Générer un lien de facture fictif pour l'exemple
                $invoice = $this->transactionRepository->getInvoiceByTransactionId($transactionId);
                return [
                    'transaction_id' => $resul->transaction_id,
                    'vote_id' => $resul->vote_id,
                    'status' => $resul->status,
                    'linkInvoice' => $invoice->link_pdf,
                ];
            } else {
                return [
                    'transaction_id' => $resul->transaction_id,
                    'vote_id' => $resul->vote_id,
                    'status' => $resul->status,
                ];
            }

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la vérification du statut : ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }


    public function updateVoteStatusAfterPayment(array $resul)
    {
        try {
            // Mapping simple des statuts transaction -> statut vote
            switch($resul['status']) {
                case 'completed':
                case 'valid':
                case 'success':
                    $voteStatus = 'confirmed';
                    break;
                case 'failed':
                    $voteStatus = 'rejected';
                    break;
                case 'pending':
                case 'processing':
                    $voteStatus = 'pending';
                    break;
                default:
                    $voteStatus = 'processing';
            }
            $dataVote = [
                'vote_id' => $resul['vote_id'],
                'status' => $voteStatus,
            ];

            $vote = $this->voteRepository->updateVoteStatus($dataVote);
            logger()->info("Statut du vote mis à jour avec succès pour le vote ID " .  $resul['vote_id'] . " en statut " . $voteStatus);
            return $vote;


        } catch (\Throwable $e) {

            \Log::error('Erreur lors de la mise à jour du statut du vote', [
                'vote_id' => $resul['vote_id'] ?? null,
                'error' => $e->getMessage(),
            ]);
            return false;
        }

    }

    public function listvoteByCampagne($campagneId)
    {
        try {
            return $this->voteRepository->getVoteByCampagne($campagneId);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des votes pour une campagne : ' . $e->getMessage());
            return null;
        }
    }

    public function detailVote($voteId)
    {
        try {
            return $this->voteRepository->getVote($voteId);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération du vote : ' . $e->getMessage());
            return null;
        }
    }

    public function saveInvoiceAfterPayment($invoiceData): bool
    {
        try {
            return $this->transactionRepository->createImvoie($invoiceData);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de la facture : ' . $e->getMessage());
            return false;
        }
    }

    public function updateLinkInvoiceAfterGeneratePdf($dataInvoice): bool
    {
        try {
            return $this->transactionRepository->updateLinkeAndNameInvoice($dataInvoice);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour du lien de la facture : ' . $e->getMessage());
            return false;
        }
    }

    public function searchVote(array $filters)
    {
        try {
            $query = Vote::join('campagnes', 'votes.campagne_id', '=', 'campagnes.campagne_id')
                ->join('etapes', 'votes.etape_id', '=', 'etapes.etape_id')
                ->join('candidats', 'votes.candidat_id', '=', 'candidats.candidat_id')
                ->where('votes.campagne_id', $filters['campagne_id'])
                ->select(
                    'votes.vote_id',
                    'votes.candidat_id',
                    'votes.campagne_id',
                    'votes.etape_id',
                    'candidats.nom as candidat_nom',
                    'candidats.prenom as candidat_prenom',
                    'candidats.email',
                    'candidats.telephone',
                    'campagnes.nom as campagne_nom',
                    'etapes.nom as etape_nom'
                );

            if ($filters['etape_id'] !== null) {
                $query->where('votes.etape_id', $filters['etape_id']);
            }

            $votes = $query->get();

            // Agrégations
            $totalQuantity = $votes->sum('quantity');
            $totalMontant = $votes->sum('montant');

            return [
                'results' => $votes,
                'total_quantity' => $totalQuantity,
                'total_montant' => $totalMontant,
                'count' => $votes->count()
            ];

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la recherche des votes : ' . $e->getMessage());
            return [
                'results' => collect(),
                'total_quantity' => 0,
                'total_montant' => 0,
                'count' => 0
            ];
        }
    }

}