<?php

namespace App\Http\Controllers\Console;


use App\Http\Controllers\Controller;
use http\Client\Request;

class ConsoleController  extends Controller
{
    public function index(){
        return view('console.index');
    }

    #CUSTOMERS
    public function listCustomer(){
        $title_back = "Tableau de bord";
        $link_back = "list_customer";
        $title = "Liste Customer";
        return view('console.listCustomer', compact('title','title_back','link_back'));
    }

    public function detailCustomer(){
        $title_back = "Tableau de bord";
        $link_back = "Detail_customer";
        $title = "Detail Customer";
        return view('console.detailCustomer', compact('title','title_back','link_back'));
    }

    public function newCustomer(Request $request)
    {
        try {

        } catch (\Exception $e) {}
    }

    #CAMPAGNES
    public function listCampagne(){
        $title_back = "Tableau de bord";
        $link_back = "list_campagne";
        $title = "Liste campagnes";
        return view('console.listCampagnes', compact('title','title_back','link_back'));
    }

    #CANDIDATS
    public function listCandidat(){
        $title_back = "Tableau de bord";
        $link_back = "list_candidat";
        $title = "Liste candidats";
        return view('console.listCandidats', compact('title','title_back','link_back'));
    }

    #VOTES
    public function listVote(){
        $title_back = "Tableau de bord";
        $link_back = "list_vote";
        $title = "Liste votes";
        return view('console.listVotes', compact('title','title_back','link_back'));
    }

    
}
