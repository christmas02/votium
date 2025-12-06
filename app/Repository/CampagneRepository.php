<?php

namespace App\Repository;

use App\Models\Campagne;
use Illuminate\Support\Facades\Auth;

class CampagneRepository {

    public function getCampagne(){}
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
            return false;
        }
    }
}