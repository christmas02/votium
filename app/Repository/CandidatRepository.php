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
            $candidat->save();

        } catch (\Throwable $th) {
            \Log::error('Erreur save candidats - CandidatRepository  : ' . $e->getMessage());
            return false;
        }
    }
}