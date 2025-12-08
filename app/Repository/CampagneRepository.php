<?php

namespace App\Repository;

use App\Models\Campagne;
use App\Models\Etape;
use Illuminate\Support\Facades\Auth;

class CampagneRepository {

    public function getListCampagne(){
        return Campagne::all();
    }
    public function getCampagneById($id){}
    public function getCampagneByCustomerId($customerId){}

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
            $campagne->condition_participation = $dataCampagne['condition_participation'];
            $campagne->save();
            return $campagne;
        } catch (\Throwable $th) {
            \Log::error('Erreur save campagne - file:CampagneRepository : ' . $e->getMessage());
            return false;
        }
    }

    public function updateCampagne($dataCampagne){}


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

        } catch (\Throwable $th) {
            \Log::error('Erreur save etape - file:CampagneRepository : ' . $e->getMessage());
            return false;
        }
    }

    public function updateEtape($dataEtape)
    {
        try {

        } catch (\Throwable $th) {
            \Log::error('Erreur update etape - file:CampagneRepository : ' . $e->getMessage());
            return false;
        }
    }

    public function getEtapeById($id){}
    public function getEtapeByCampagneId($customerId){}
}