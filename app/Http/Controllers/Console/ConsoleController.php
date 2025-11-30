<?php

namespace App\Http\Controllers\Console;


use App\Http\Controllers\Controller;
use http\Client\Request;

class ConsoleController  extends Controller
{
    public function index(){
        return view('console.index');
    }

    public function listCustomer(){
        $title_back = "Tableau de bord";
        $link_back = "list_customer";
        $title = "Liste Customer";
        return view('console.listCustomer', compact('title','title_back','link_back'));
    }

    public function newCustomer(Request $request)
    {
        try {

        } catch (\Exception $e) {}
    }
}
