<?php

namespace App\Repository;

use App\Models\Candidat;
use App\Models\CandidatEtapCategoryCampagne;
use App\Models\Etape;
use Illuminate\Support\Facades\Auth;

class CandidatRepository
{
    public function save($dataCandidat)
    {
        try {
            $candidat = new Candidat;
            $candidat->candidat_id = $dataCandidat['candidat_id'];
            $candidat->name = $dataCandidat['name'];
            $candidat->email = $dataCandidat['email'];
            $candidat->phonenumber = $dataCandidat['telephone'];
            $candidat->sexe = $dataCandidat['sexe'];
            $candidat->date_naissance = $dataCandidat['date_naissance'];
            $candidat->ville = $dataCandidat['ville'];
            $candidat->pays = $dataCandidat['pays'];
            $candidat->profession = $dataCandidat['profession'];
            $candidat->photo = $dataCandidat['photo'];
            $candidat->description = $dataCandidat['description'];
            $candidat->data = $dataCandidat['data'];
            $candidat->is_active = true;
            return $candidat->save();

        } catch (\Throwable $e) {
            \Log::error('Erreur save candidats - CandidatRepository  : ' . $e->getMessage());
            return false;
        }
    }

    public function update($dataCandidat)
    {
        try {
            $candidat = Candidat::where('candidat_id', $dataCandidat['candidat_id'])->first();
            // TO DO UPDATE CANDIDAT INFO
            $candidat->name = $dataCandidat['name'];
            $candidat->email = $dataCandidat['email'];
            $candidat->telephone = $dataCandidat['telephone'];
            $candidat->sexe = $dataCandidat['sexe'];
            $candidat->date_naissance = $dataCandidat['date_naissance'];
            $candidat->ville = $dataCandidat['ville'];
            $candidat->pays = $dataCandidat['pays'];
            $candidat->profession = $dataCandidat['profession'];
            $candidat->photo = $dataCandidat['photo'];
            $candidat->description = $dataCandidat['description'];
            $candidat->data = $dataCandidat['data'];
            $candidat->save();
            return true;

        } catch (\Throwable $e) {
            \Log::error('Erreur update candidats - CandidatRepository  : ' . $e->getMessage());
            return false;
        }
    }

    public function deleteCandidatCampagne($candidatId)
    {
        try {
            $candidat = Candidat::where('candidat_id', $candidatId)->first();
            $candidat->isActive = false;
            $candidat->save();
            return true;

        } catch (\Throwable $e) {
            \Log::error('Erreur delete candidat - CandidatRepository  : ' . $e->getMessage());
            return false;
        }
    }

    public function getCandidat($candidatId)
    {
        try {
            return Candidat::where('candidat_id', $candidatId)->first();
        } catch (\Throwable $e) {
            \Log::error('Erreur get candidat - CandidatRepository  : ' . $e->getMessage());
            return false;
        }
    }

    public function candidatExistForCampagne($dataCandidat)
    {
        try {
            $result = CandidatEtapCategoryCampagne::where('campagne_id', $dataCandidat['campagne_id'])
                ->where('candidat_id', $dataCandidat['candidats_id'])
                ->first();
            return $result;

        } catch (\Throwable $e) {
            \Log::error('Erreur get candidat exist for campagne - CandidatRepository  : ' . $e->getMessage());
            return false;
        }
    }

    public function candidatsByCampagne($campagneId)
    {
        try {
            return Candidat::where('campagne_id', $campagneId)->get();
        } catch (\Throwable $e) {
            \Log::error('Erreur get candidats by campagne - CandidatRepository  : ' . $e->getMessage());
            return false;
        }
    }

    // enregistrer les candidats avec leur etape et categorie associer a une campagne
    public function candidatWithEtapAndCategoriByCampagne($data, $statut)
    {
        try {
            $result = new CandidatEtapCategoryCampagne;
            $result->candidat_etap_id = $data['candidat_etap_id'];
            $result->campagne_id = $data['campagne_id'];
            $result->candidat_id  = $data['candidat_id'];
            $result->etape_id = $data['etape_id']; // etape id obligatoire
            $result->category_id = $data['category_id'];
            $result->is_active = $statut;
            $result->save();
            return $result;

        } catch (\Throwable $e) {
            \Log::error('Erreur get candidats with etap and categori by campagne - CandidatRepository  : ' . $e->getMessage());
            return false;
        }
    }

    public function updateCandidatWithEtapAndCategoriByCampagne($data)
    {
        try {
            $result = CandidatEtapCategoryCampagne::where('campagne_id', $data['campagne_id'])
                ->where('candidat_id', $data['candidats_id'])
                ->first();
            $result->campagne_id = $data['campagne_id'];
            $result->candidat_id  = $data['candidats_id'];
            $result->etape_id = $data['etape_id']; // etape id obligatoire
            $result->category_id = $data['category_id'];
            $result->is_active = true;
            $result->save();
            return $result;

        } catch (\Throwable $e) {
            \Log::error('Erreur get candidats with etap and categori by campagne - CandidatRepository  : ' . $e->getMessage());
            return false;
        }
    }

    public function detailCandidatWithEtapAndCategoriByCampagne($data)
    {
        try {
            $result = CandidatEtapCategoryCampagne::where('campagne_id', $data['campagne_id'])
                ->where('candidat_id', $data['candidats_id'])
                ->get();
            return $result;

        } catch (\Throwable $e) {
            \Log::error('Erreur get candidats with etap and categori by campagne - CandidatRepository  : ' . $e->getMessage());
            return false;
        }
    }


}