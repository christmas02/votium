<?php

namespace App\Services;

use App\Repository\CampagneRepository;

class CampagneService
{
    protected $campagneRepository;

    public function __construct(CampagneRepository $campagneRepository){
        $this->campagneRepository = $campagneRepository;
    }

    // CAMPAGNE METHODS --- MODEL CAMPAGNE
    public function saveNewCampagne($dataCampagne){
       $campagne = $this->campagneRepository->saveCampagne($dataCampagne);
       return $campagne;
    }

    public function listCampagnes(){
        $campagnes = $this->campagneRepository->getListCampagne();
        return $campagnes;
    }

    public function updateExistingCampagne($dataCampagne){
        $campagne = $this->campagneRepository->updateCampagne($dataCampagne);
        return $campagne;
    }

    public function detailCampagne($campagneId){
        $campagne = $this->campagneRepository->getCampagneById($campagneId);
        return $campagne;
    }

    public function listCampagnesByCustomerId($customerId){
        $campagnes = $this->campagneRepository->getCampagneByCustomerId($customerId);
        return $campagnes;
    }

    // ETAPE METHODS --- MODEL ETAPE

    public function saveNewEtape($dataEtape){
        $etape = $this->campagneRepository->saveEtape($dataEtape);
        return $etape;
    }

    public function updateEtape($dataEtape)
    {
        $etape = $this->campagneRepository->updateEtape($dataEtape);
        return $etape;
    }

    public function listEtapesByCampagneId($campagne_id){
        $etapes = $this->campagneRepository->getEtapeByCampagneId($campagne_id);
        return $etapes;
    }

    public function detailEtape($etapeId)
    {
        $etapes = $this->campagneRepository->getEtapeById($etapeId);
        return $etapes;
    }
}