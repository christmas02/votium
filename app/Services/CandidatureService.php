<?php

namespace App\Services;

use App\Repository\CandidatRepository;
use Illuminate\Support\Facades\DB;

class CandidatureService
{
    protected $candidatRepository;

    public function __construct(CandidatRepository $candidatRepository)
    {
        $this->candidatRepository = $candidatRepository;
    }

    public function newCandidat($data)
    {
        try {
            DB::beginTransaction();

            // ✅ ÉTAPE 1 : Générer le numéro de candidat AVANT d'enregistrer
            $candidatNumber = $this->generateCandidatNumber($data['campagne_id']);
            if (!$candidatNumber) {
                \Log::error('Impossible de générer le numéro de candidat pour la campagne : ' . $data['campagne_id']);
                DB::rollBack();
                return false;
            }
            $data['numero_candidat'] = $candidatNumber;

            // ✅ ÉTAPE 2 : Sauvegarder le candidat avec son numéro
            $this->candidatRepository->save($data);

            // ✅ ÉTAPE 3 : Ajouter le candidat à la campagne/étape/catégorie
            $this->candidatRepository->candidatWithEtapAndCategoriByCampagne($data, true);

            DB::commit();
            \Log::info('Candidat créé avec succès avec le numéro : ' . $candidatNumber);
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors de la sauvegarde du candidat : ' . $e->getMessage());
            return false;
        }
    }

    public function updateInfoCandidat($data)
    {
        try {
            DB::beginTransaction();
            // TO DO UPDATE INFO CANDIDAT
            $this->candidatRepository->update($data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors de la mise à jour du candidat : ' . $e->getMessage());
            return false;
        }
    }

    public function candidat($candidatId)
    {
        try {
            return $this->candidatRepository->getCandidat($candidatId);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération du candidat : ' . $e->getMessage());
            return null;
        }
    }

    public function listCandidatForCampagne($campagneId)
    {
        try {
            return $this->candidatRepository->candidatsByCampagne($campagneId);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des candidats pour une campagne : ' . $e->getMessage());
            return null;
        }
    }

    public function addCandidatInEtapeAndCategoryForCampagne($data)
    {
        try {
            DB::beginTransaction();

            // ✅ ÉTAPE 1 : Vérifier si le candidat existe
            $candidat = $this->candidatRepository->candidatExistForCampagne($data);
            if (!$candidat) {
                \Log::warning('Aucun candidat trouvé pour cette campagne avec l\'ID : ' . $data['candidat_id']);
                DB::rollBack();
                return false;
            }
            
            // ✅ ÉTAPE 2 : Générer le numéro de candidat AVANT d'ajouter à la campagne
            $candidatNumber = $this->generateCandidatNumber($data['campagne_id']);
            if (!$candidatNumber) {
                \Log::error('Impossible de générer le numéro de candidat pour la campagne : ' . $data['campagne_id']);
                DB::rollBack();
                return false;
            }
            $data['numero_candidat'] = $candidatNumber;
            
            // ✅ ÉTAPE 3 : Ajouter le candidat à l'étape et la catégorie pour la campagne
            $this->candidatRepository->candidatWithEtapAndCategoriByCampagne($data, true);

            \Log::info('Candidat ajouté avec succès pour cette campagne avec le numéro : ' . $candidatNumber . ' (ID: ' . $data['candidat_id'] . ')');
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors de l\'ajout du candidat dans l\'étape et la catégorie pour une campagne: ' . $e->getMessage());
            return false;
        }
    }

    public function removeCandidatInEtapeAndCategoryForCampagne($data)
    {
        try {
            DB::beginTransaction();
            // verifier si le candidat existe
            $candidat = $this->candidatRepository->candidatExistForCampagne($data);
            if (!$candidat) {
                \Log::warning('Aucun candidat trouvé pour cette campagne avec l\'ID : ' . $data['candidat_id']);
                DB::rollBack();
                return false;
            }
            
            // TO DO REMOVE CANDIDAT IN ETAPE AND CATEGORY FOR CAMPAGNE
            $this->candidatRepository->candidatWithEtapAndCategoriByCampagne($data, false);
            \Log::info('Candidat supprimé avec succès pour cette campagne avec l\'ID : ' . $data['candidat_id']);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors de la suppression du candidat dans l\'étape et la catégorie pour une campagne : ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Recherche des candidats selon les critères fournis
     *
     * @param array $filters
     *  - campagne_id (uuid|int|null)
     *  - etape_id (uuid|int|null)
     *  - category_id (uuid|int|null)
     * @return \Illuminate\Support\Collection
     */

    public function searchCandidat(array $filters)
    {
        try {
            // Construire la requête (SANS get)
            $query = DB::table('candidat_etap_category_campagnes as cecc')
                ->join('candidats as c', 'c.candidat_id', '=', 'cecc.candidat_id')
                ->join('campagnes as camp', 'camp.campagne_id', '=', 'cecc.campagne_id')
                ->leftJoin('votes as v', function ($join) {
                    $join->on('v.candidat_id', '=', 'c.candidat_id')
                        ->on('v.campagne_id', '=', 'cecc.campagne_id')
                        ->where('v.status', '=', 'confirmed');
                })
                ->select(
                    'c.candidat_id',
                    'c.name',
                    'c.email',
                    'c.phonenumber as telephone',
                    'c.sexe',
                    'c.date_naissance',
                    'c.ville',
                    'c.pays',
                    'c.profession',
                    'c.photo',
                    'c.description',
                    'c.created_at',
                    'c.updated_at',
                    'cecc.campagne_id',
                    'cecc.etape_id',
                    'cecc.category_id',
                    DB::raw('COUNT(v.vote_id) as votes_count'),
                    DB::raw('COALESCE(SUM(v.quantity), 0) as total_quantity')
                )
                ->groupBy(
                    'c.candidat_id',
                    'c.name',
                    'c.email',
                    'c.phonenumber',
                    'c.sexe',
                    'c.date_naissance',
                    'c.ville',
                    'c.pays',
                    'c.profession',
                    'c.photo',
                    'c.description',
                    'c.created_at',
                    'c.updated_at',
                    'cecc.campagne_id',
                    'cecc.etape_id',
                    'cecc.category_id',
                );

            //FILTRE OBLIGATOIRE PAR CLIENT (toujours appliqué)
            if (!empty($filters['customer_id'])) {
                $query->where('camp.customer_id', $filters['customer_id']);
            }
            
            //Appliquer les filtres
            if (!empty($filters['campagne_id'])) {
                $query->where('cecc.campagne_id', $filters['campagne_id']);
            }

            if (!empty($filters['etape_id'])) {
                $query->where('cecc.etape_id', $filters['etape_id']);
            }

            if (!empty($filters['category_id'])) {
                $query->where('cecc.category_id', $filters['category_id']);
            }

            // Exécuter la requête UNE SEULE FOIS
            return $query->get();
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la recherche des candidats : ' . $e->getMessage());
            return collect();
        }
    }

    // public function searchCandidat(array $filters)
    // {
    //     try {
    //         // $query = DB::table('candidat_etap_category_campagnes as cecc')
    //         //     ->join('candidats as c', 'c.candidat_id', '=', 'cecc.candidat_id')
    //         //     ->join('votes as v', function ($join) {
    //         //         $join->on('v.candidat_id', '=', 'c.candidat_id')
    //         //             ->on('v.campagne_id', '=', 'cecc.campagne_id');
    //         //     })
    //         //     ->select(
    //         //         'c.*',
    //         //         'cecc.campagne_id',
    //         //         'cecc.etape_id',
    //         //         'cecc.category_id',
    //         //         DB::raw('COUNT(v.vote_id) as votes_count'),
    //         //         DB::raw('COALESCE(SUM(v.quantity), 0) as total_quantity')
    //         //     )
    //         //     ->groupBy('c.candidat_id', 'cecc.campagne_id');

    //         if (!empty($filters['campagne_id'])) {
    //             $query->where('cecc.campagne_id', $filters['campagne_id']);
    //         }

    //         if (!empty($filters['etape_id'])) {
    //             $query->where('cecc.etape_id', $filters['etape_id']);
    //         }

    //         if (!empty($filters['category_id'])) {
    //             $query->where('cecc.category_id', $filters['category_id']);
    //         }

    //         return $query->get();
    //     } catch (\Exception $e) {
    //         \Log::error('Erreur lors de la recherche des candidats : ' . $e->getMessage());
    //         return collect();
    //     }
    // }

    /**
     * Génère le numéro séquentiel du candidat formaté (0001 à 1000)
     * basé sur le nombre de candidats déjà inscrits pour une campagne
     *
     * @param string|int $campagne_id
     * @return string|null Numéro formaté (ex: "0001", "0042", "1000") ou null si limite atteinte
     */
    private function generateCandidatNumber($campagne_id)
    {
        try {
            // Compter les candidats existants pour cette campagne
            $count = DB::table('candidat_etap_category_campagnes')
                ->where('campagne_id', $campagne_id)
                ->count();

            // Le prochain numéro est count + 1
            $nextNumber = $count + 1;

            // Vérifier que le numéro ne dépasse pas 1000
            if ($nextNumber > 1000) {
                \Log::warning('Limite de 1000 candidats atteinte pour la campagne : ' . $campagne_id);
                return null;
            }

            // Formater le numéro avec des zéros à gauche (0001, 0002, ..., 1000)
            return str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la génération du numéro de candidat : ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Bascule le statut d'activation d'un candidat (actif -> inactif ou inactif -> actif)
     *
     * @param string|int $candidatId
     * @return bool
     */
    public function toggleCandidatStatus($candidatId)
    {
        try {
            return $this->candidatRepository->toggleCandidatStatus($candidatId);
        } catch (\Exception $e) {
            \Log::error('Erreur lors du basculement du statut du candidat : ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Définit explicitement le statut d'activation d'un candidat
     *
     * @param string|int $candidatId
     * @param bool $isActive (true pour activer, false pour désactiver)
     * @return bool
     */
    public function setCandidatStatus($candidatId, $isActive = true)
    {
        try {
            return $this->candidatRepository->setCandidatStatus($candidatId, $isActive);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la modification du statut du candidat : ' . $e->getMessage());
            return false;
        }
    }

}
