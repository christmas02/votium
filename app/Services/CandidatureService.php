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
            // TO DO SAVE INFO CANDIDAT
            $this->candidatRepository->save($data);
            // ADD
            $this->candidatRepository->candidatWithEtapAndCategoriByCampagne($data, true);
            DB::commit();
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
            // verifier si le candidat existe
            $candidat = $this->candidatRepository->candidatExistForCampagne($data);
            if ($candidat) {
                // TO DO ADD CANDIDAT IN ETAPE AND CATEGORY FOR CAMPAGNE
                $this->candidatRepository->candidatWithEtapAndCategoriByCampagne($data, true);
                \Log::info('Candidat trouvé pour cette campagne avec l\'ID : ' . $data['candidat_id']);
                return true;
            }else {
                \Log::info('Aucun candidat trouvé pour cette campagne avec l\'ID : ' . $data['candidat_id'] . '. Création d\'un nouveau candidat.');
            }
            DB::commit();
            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'ajout du candidat dans l\'étape et la catégorie pur une campagme: ' . $e->getMessage());
            return false;
        }
    }

    public function removeCandidatInEtapeAndCategoryForCampagne($data)
    {
        try {
            DB::beginTransaction();
            // verifier si le candidat existe
            $candidat = $this->candidatRepository->candidatExistForCampagne($data);
            if ($candidat) {
                // TO DO ADD CANDIDAT IN ETAPE AND CATEGORY FOR CAMPAGNE
                $this->candidatRepository->candidatWithEtapAndCategoriByCampagne($data, false);
                \Log::info('Candidat trouvé pour cette campagne avec l\'ID : ' . $data['candidat_id']);
                return false;
            }else {
                \Log::info('Aucun candidat trouvé pour cette campagne avec l\'ID : ' . $data['candidat_id'] . '. Création d\'un nouveau candidat.');
            }
            DB::commit();
            return true;

        } catch (\Exception $e) {
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
        $query = DB::table('candidat_etap_category_campagnes as cecc')
            ->join('candidats as c', 'c.candidat_id', '=', 'cecc.candidat_id')
            ->select('c.*')
            ->distinct();

        if (!empty($filters['campagne_id'])) {
            $query->where('cecc.campagne_id', $filters['campagne_id']);
        }

        if (!empty($filters['etape_id'])) {
            $query->where('cecc.etape_id', $filters['etape_id']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('cecc.category_id', $filters['category_id']);
        }

        return $query->get();
    }

}