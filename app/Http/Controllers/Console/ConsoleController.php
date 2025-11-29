<?php

namespace App\Http\Controllers\Console;


use App\Http\Controllers\Controller;

class ConsoleController  extends Controller
{
    public function index(){
        return view('console.index');
    }
}
