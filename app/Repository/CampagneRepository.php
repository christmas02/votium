<?php

namespace App\Repository;

use App\Models\Campagne;
use App\Models\CategoryCampagne;
use App\Models\Etape;
use Illuminate\Support\Facades\Auth;

class CampagneRepository {

    // CAMPAGNE METHODS
    public function getListCampagne(){
        return Campagne::all();
    }
    public function getCampagneById($campagne_id){
        return Campagne::where('campagne_id', $campagne_id)->first();
    }
    public function getCampagneByCustomerId($customerId){
        return Campagne::where('customer_id', $customerId)->get();
    }

    public function saveCampagne($dataCampagne)
    {
        try {
            $campagne = new Campagne();
            $campagne->name = $dataCampagne['name'];
            $campagne->campagne_id = $dataCampagne['campagne_id'];
            $campagne->description = $dataCampagne['description'];
            $campagne->image_couverture = $dataCampagne['image_couverture'];
            $campagne->customer_id = $dataCampagne['customer_id'];
            $campagne->text_cover_isActive = $dataCampagne['text_cover_isActive'];
            $campagne->inscription_isActive = $dataCampagne['inscription_isActive'];
            $campagne->inscription_date_debut = $dataCampagne['inscription_date_debut'];
            $campagne->inscription_date_fin = $dataCampagne['inscription_date_fin'];
            $campagne->afficher_montant_pourcentage = $dataCampagne['afficher_montant_pourcentage'];
            $campagne->ordonner_candidats_votes_decroissants = $dataCampagne['ordonner_candidats_votes_decroissants'];
            $campagne->quantite_vote = $dataCampagne['quantite_vote'];
            $campagne->color_primaire = $dataCampagne['color_primaire'];
            $campagne->color_secondaire = $dataCampagne['color_secondaire'];
            $campagne->heure_debut_inscription = $dataCampagne['heure_debut_inscription'];
            $campagne->heure_fin_inscription = $dataCampagne['heure_fin_inscription'];
            $campagne->identifiants_personnalises_isactive = $dataCampagne['identifiants_personnalises_isActive'];
            $campagne->is_active = $dataCampagne['is_active'];
            $campagne->condition_participation = $dataCampagne['condition_participation'];
            $campagne->save();
            return $campagne;
        } catch (\Throwable $e) {
            \Log::error('Erreur save campagne - file:CampagneRepository : ' . $e->getMessage());
            return false;
        }
    }

    public function updateCampagne($dataCampagne){
        $campagne = Campagne::find($dataCampagne['campagne_id']);
        try {
            $campagne->name = $dataCampagne['name'];
            $campagne->description = $dataCampagne['description'];
            $campagne->image_couverture = $dataCampagne['image_couverture'];
            $campagne->text_cover_isActive = $dataCampagne['text_cover_isActive'];
            $campagne->inscription_isActive = $dataCampagne['inscription_isActive'];
            $campagne->inscription_date_debut = $dataCampagne['inscription_date_debut'];
            $campagne->inscription_date_fin = $dataCampagne['inscription_date_fin'];
            $campagne->heure_debut_inscription = $dataCampagne['heure_debut_inscription'];
            $campagne->heure_fin_inscription = $dataCampagne['heure_fin_inscription'];
            $campagne->afficher_montant_pourcentage = $dataCampagne['afficher_montant_pourcentage'];
            $campagne->ordonner_candidats_votes_decroissants = $dataCampagne['ordonner_candidats_votes_decroissants'];
            $campagne->quantite_vote = $dataCampagne['quantite_vote'];
            $campagne->color_primaire = $dataCampagne['color_primaire'];
            $campagne->color_secondaire = $dataCampagne['color_secondaire'];
            $campagne->condition_participation = $dataCampagne['condition_participation'];
            $campagne->save();
            return $campagne;
        } catch (\Throwable $e) {
            \Log::error('Erreur update campagne - file:CampagneRepository : ' . $e->getMessage());
            return false;  
        }
    }

    // ETAPE METHODS
    public function saveEtape($dataEtape)
    {
        try {
            $etape = new Etape();
            $etape->name = $dataEtape['name'];
            $etape->campagne_id = $dataEtape['campagne_id'];
            $etape->etape_id = $dataEtape['etape_id'];
            $etape->date_debut = $dataEtape['date_debut'];
            $etape->date_fin = $dataEtape['date_fin'];
            $etape->heure_debut = $dataEtape['heure_debut'];
            $etape->heure_fin = $dataEtape['heure_fin'];
            $etape->description = $dataEtape['description'];
            $etape->type_eligibility = $dataEtape['type_eligibility'];
            $etape->seuil_selection = $dataEtape['seuil_selection'];
            $etape->prix_vote = $dataEtape['prix_vote'];
            $etape->renitialisation = $dataEtape['renitialisation'];
            $etape->save();
            return $etape;

        } catch (\Throwable $e) {
            \Log::error('Erreur save etape - file:CampagneRepository : ' . $e->getMessage());
            return false;
        }
    }

    public function updateEtape($dataEtape)
    {
        try {
            $etape = Etape::where('etape_id', $dataEtape['etape_id'])->first();
            $etape->name = $dataEtape['name'];
            $etape->date_debut = $dataEtape['date_debut'];
            $etape->date_fin = $dataEtape['date_fin'];
            $etape->heure_debut = $dataEtape['heure_debut'];
            $etape->heure_fin = $dataEtape['heure_fin'];
            $etape->description = $dataEtape['description'];
            $etape->type_eligibility = $dataEtape['type_eligibility'];
            $etape->seuil_selection = $dataEtape['seuil_selection'];
            $etape->prix_vote = $dataEtape['prix_vote'];
            $etape->renitialisation = $dataEtape['renitialisation'];
            $etape->save();
            return $etape;

        } catch (\Throwable $e) {
            \Log::error('Erreur update etape - file:CampagneRepository : ' . $e->getMessage());
            return false;
        }
    }

    public function getEtapeById($etapeId){
        try {
            return Etape::where('etape_id', $etapeId)->first();
        } catch (\Throwable $e) {
            \Log::error('Erreur get etape by id - file:CampagneRepository : ' . $e->getMessage());
            return false;
        }
    }

    public function getEtapeByCampagneId($campagneId){
        try {
            return Etape::where('campagne_id', $campagneId)->get();
        } catch (\Throwable $e) {
            \Log::error('Erreur get etape by campagne id - file:CampagneRepository : ' . $e->getMessage());
            return false;
        }
    }

    // CATEGORY METHODS

    public function saveCategory($dataCategory)
    {
        try {
            // TO DO SAVE CATEGORY
            $category = new CategoryCampagne();
            $category->name = $dataCategory['name'];
            $category->campagne_id = $dataCategory['campagne_id'];
            $category->category_id = $dataCategory['category_id'];
            $category->description = $dataCategory['description'];
            $category->icon = $dataCategory['icon'];
            $category->is_active = true;
            $category->save();
            return $category;

        } catch (\Throwable $e) {
            \Log::error('Erreur save category - file:CampagneRepository : ' . $e->getMessage());
            return false;
        }
    }

    public function updateCategory($dataCategory)
    {
        try {
            $category = CategoryCampagne::where('category_id', $dataCategory['category_id'])->first();
            // TO DO UPDATE CATEGORY
            $category->name = $dataCategory['name'];
            $category->description = $dataCategory['description'];
            $category->icon = $dataCategory['icon'];
            $category->save();
            return $category;

        } catch (\Throwable $e) {
            \Log::error('Erreur update category - file:CampagneRepository : ' . $e->getMessage());
            return false;
        }
    }

    public function deleteCategory($categoryId)
    {
        try {
            $category = CategoryCampagne::where('category_id', $categoryId)->first();
            $category->is_active = false;
            $category->save();
            return $category;

        } catch (\Throwable $e) {
            \Log::error('Erreur delete category - file:CampagneRepository : ' . $e->getMessage());
            return false;
        }
    }

    public function getCategoryById($categoryId){
        try {
            return CategoryCampagne::where('category_id', $categoryId)->first();
        } catch (\Throwable $e) {
            \Log::error('Erreur get category by id - file:CampagneRepository : ' . $e->getMessage());
            return false;
        }
    }

    public function getCategoryByCampagneId($campagne_id)
    {
        try {
            return CategoryCampagne::where('campagne_id', $campagne_id)->where('is_active', true)->get();
        } catch (\Throwable $e) {
            \Log::error('Erreur get category by campagne id - file:CampagneRepository : ' . $e->getMessage());
            return false;
        }
    }
}