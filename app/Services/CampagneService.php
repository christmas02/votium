<?php

namespace App\Services;

use App\Repository\CampagneRepository;

class CampagneService
{
    protected $campagneRepository;

    public function __construct(CampagneRepository $campagneRepository){
        $this->campagneRepository = $campagneRepository;
    }

    // CAMPAGNE METHODS --- MODEL CAMPAGNE ------
    // create new campagne
    public function saveNewCampagne($dataCampagne){
       $campagne = $this->campagneRepository->saveCampagne($dataCampagne);
       return $campagne;
    }

    // list all campagnes
    public function listCampagnes(){
        $campagnes = $this->campagneRepository->getListCampagne();
        return $campagnes;
    }

    // update existing campagne
    public function updateExistingCampagne($dataCampagne){
        $campagne = $this->campagneRepository->updateCampagne($dataCampagne);
        return $campagne;
    }

    // detail campagne by id
    public function detailCampagne($campagneId){
        $campagne = $this->campagneRepository->getCampagneById($campagneId);
        return $campagne;
    }

    // list campagnes by customer id
    public function listCampagnesByCustomerId($customerId){
        $campagnes = $this->campagneRepository->getCampagneByCustomerId($customerId);
        return $campagnes;
    }

    // ETAPE METHODS --- MODEL ETAPE
    // create new etape
    public function saveNewEtape($dataEtape){
        $etape = $this->campagneRepository->saveEtape($dataEtape);
        return $etape;
    }

    // update etape
    public function updateEtape($dataEtape)
    {
        $etape = $this->campagneRepository->updateEtape($dataEtape);
        return $etape;
    }

    // list etapes by campagne id
    public function listEtapesByCampagneId($campagne_id){
        $etapes = $this->campagneRepository->getEtapeByCampagneId($campagne_id);
        return $etapes;
    }

    // detail etape by id
    public function detailEtape($etapeId)
    {
        $etapes = $this->campagneRepository->getEtapeById($etapeId);
        return $etapes;
    }

    // CATEGORY METHODS --- MODEL CATEGORY

    // create new category
    public function saveNewCategory($dataCategory){
        $category = $this->campagneRepository->saveCategory($dataCategory);
        return $category;
    }

    // update category
    public function updateCategory($dataCategory){
        $category = $this->campagneRepository->updateCategory($dataCategory);
        return $category;
    }

    // delete category
    public function deleteCategory($categoryId){
        $category = $this->campagneRepository->deleteCategory($categoryId);
        return $category;
    }

    // list categories by campagne id
    public function listCategoriesByCampagneId($campagne_id){
        $categories = $this->campagneRepository->getCategoryByCampagneId($campagne_id);
        return $categories;
    }

    // detail category by id
    public function detailCategory($categoryId){
        $category = $this->campagneRepository->getCategoryById($categoryId);
        return $category;
    }
}