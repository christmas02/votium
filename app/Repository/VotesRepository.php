<?php

namespace App\Repository;

use App\Models\Vote;

class VotesRepository
{
    public function getVoteByCampagne($campagneId)
    {
        try {
            $votes = Vote::where('campagne_id', $campagneId)->get();
            return $votes;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des votes par campagne : ' . $e->getMessage());
            return false;
        }
    }
    public function getVote($voteId)
    {
        try {
            $vote = Vote::where('vote_id', $voteId)->first();
            return $vote;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération du vote : ' . $e->getMessage());
            return false;
        }
    }

    public function save($dataVote)
    {
        try {
            $vote = new Vote();
            $vote->vote_id = $dataVote['vote_id'];
            $vote->candidat_id = $dataVote['candidat_id'];
            $vote->campagne_id = $dataVote['campagne_id'];
            $vote->etate_id = $dataVote['etate_id'];
            $vote->quantity = $dataVote['quantity'];
            $vote->name = $dataVote['name'];
            $vote->email = $dataVote['email'];
            $vote->phoneNumber = $dataVote['phoneNumber'];
            $vote->montant = $dataVote['amount'];
            $vote->status = 'created';
            $vote->date_vote = now();
            $vote->save();

            return true;

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la sauvegarde du vote : ' . $e->getMessage());
            return false;
        }
    }

    public function updateVoteStatus($dataVote)
    {
        try {
            $vote = Vote::where('vote_id', $dataVote['vote_id'])->first();
            $vote->status = $dataVote['status'];
            $vote->save();
            return $vote;

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