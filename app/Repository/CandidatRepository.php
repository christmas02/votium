<?php

namespace App\Repository;

use App\Models\Candidat;
use App\Models\Etape;
use Illuminate\Support\Facades\Auth;

class CandidatRepository
{
    public function save($dataCandidat)
    {
        try {
            $candidat = new Candidat;
            $candidat->nom = $dataCandidat['nom'];
            $candidat->prenom = $dataCandidat['prenom'];
            $candidat->email = $dataCandidat['email'];
            $candidat->telephone = $dataCandidat['telephone'];
            $candidat->sexe = $dataCandidat['sexe'];
            $candidat->date_naissance = $dataCandidat['date_naissance'];
            $candidat->ville = $dataCandidat['ville'];
            $candidat->pays = $dataCandidat['pays'];
            $candidat->profession = $dataCandidat['profession'];
            $candidat->photo = $dataCandidat['photo'];
            $candidat->description = $dataCandidat['description'];
            $candidat->campagne_id = $dataCandidat['campagne_id'];
            $candidat->data = $dataCandidat['data'];
            $candidat->isActive = true;
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
            $candidat->nom = $dataCandidat['nom'];
            $candidat->prenom = $dataCandidat['prenom'];
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

    public function candidatsByCampagne($campagneId)
    {
        try {
            return Candidat::where('campagne_id', $campagneId)->get();
        } catch (\Throwable $e) {
            \Log::error('Erreur get candidats by campagne - CandidatRepository  : ' . $e->getMessage());
            return false;
        }
    }
}