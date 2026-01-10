<?php

namespace App\Repository;

use App\Models\Vote;

class VotesRepository
{
    public function save($dataVote): bool
    {
        try {
            $vote = new Vote();
            $vote->votes_id = $dataVote['votes_id'];
            $vote->candidat_id = $dataVote['candidat_id'];
            $vote->campagne_id = $dataVote['campagne_id'];
            $vote->etate_id = $dataVote['etate_id'];
            $vote->quantity = $dataVote['quantity'];
            $vote->montant = $dataVote['montant'];
            $vote->status = $dataVote['status'];
            $vote->date_vote = $dataVote['date_vote'];

            $vote->save();
            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la sauvegarde du vote : ' . $e->getMessage());
            return false;
        }
    }

    public function updateVoteStatus($dataVote): bool
    {
        try {
            $vote = Vote::where('votes_id', $dataVote['votes_id'])->first();
            // TO DO UPDATE VOTE STATUS
            $vote->status = $dataVote['status'];

            $vote->save();
            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour du statut du vote : ' . $e->getMessage());
            return false;
        }
    }

    public function update($dataVote): bool
    {
        try {
            $vote = Vote::where('votes_id', $dataVote['votes_id'])->first();
            // TO DO UPDATE VOTE INFO
            $vote->candidat_id = $dataVote['candidat_id'];
            $vote->campagne_id = $dataVote['campagne_id'];
            $vote->etate_id = $dataVote['etate_id'];
            $vote->quantity = $dataVote['quantity'];
            $vote->montant = $dataVote['montant'];
            $vote->status = $dataVote['status'];
            $vote->date_vote = $dataVote['date_vote'];

            $vote->save();
            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour du vote : ' . $e->getMessage());
            return false;
        }
    }

    public function search()
    {
        try {

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la recherche des votes : ' . $e->getMessage());
            return false;
        }
    }

}