<?php

namespace App\Http\Controllers\Business;
use App\Http\Controllers\Controller;

class BusinessController extends Controller
{
    public function index(){
        return view('business.index');
    }
}