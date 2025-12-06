<?php

namespace App\Services;

use App\Repository\CampagneRepository;

class CampagneService
{
    protected $campagneRepository;

    public function __construct(CampagneRepository $campagneRepository){
        $this->campagneRepository = $campagneRepository;
    }

    public function saveNewCampagne($dataCampagne)
    {
       $campagne = $this->campagneRepository->saveCampagne($dataCampagne);
       return $campagne;
    }

    public function getCampagnes(){}
}