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
                \Log::info('Candidat trouvé pour cette campagne avec l\'ID : ' . $data['candidat_id']);
                return false;
            }else {
                // TO DO ADD CANDIDAT IN ETAPE AND CATEGORY FOR CAMPAGNE
                $this->candidatRepository->candidatWithEtapAndCategoriByCampagne($data);
                \Log::info('Aucun candidat trouvé pour cette campagne avec l\'ID : ' . $data['candidat_id'] . '. Création d\'un nouveau candidat.');
            }
            DB::commit();
            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'ajout du candidat dans l\'étape et la catégorie pur une campagme: ' . $e->getMessage());
            return false;
        }
    }

}