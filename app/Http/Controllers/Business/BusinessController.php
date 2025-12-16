<?php

namespace App\Http\Controllers\Business;
use App\Http\Controllers\Controller;

class BusinessController extends Controller
{
    public function index(){
        return view('business.index');
    }

    #Paramètres du profil
    public function parametreCompte(){
        $title_back = "Tableau de bord";
        $link_back = "parametre_compte";
        $title = "Paramètres du compte";
        return view('business.detailCustomer', compact('title','title_back','link_back'));
    }

     #CANDIDATS
    public function listCandidat(){
        $title_back = "Tableau de bord";
        $link_back = "list_candidat";
        $title = "Liste candidats";
        return view('business.listCandidats', compact('title','title_back','link_back'));
    }

    #VOTES
    public function listVote(){
        $title_back = "Tableau de bord";
        $link_back = "list_vote";
        $title = "Liste votes";
        return view('business.listVotes', compact('title','title_back','link_back'));
    }

    #RETRAITS
    public function listRetrait(){
        $title_back = "Tableau de bord";
        $link_back = "list_retrait";
        $title = "Liste retraits";
        return view('business.listRetraits', compact('title','title_back','link_back'));
    }
}