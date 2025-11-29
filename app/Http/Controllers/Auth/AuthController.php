<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Routing\Controller as BaseController;

class AuthController  extends BaseController
{
    public function screenLogin()
    {
        return view('auth.login');
    }

    public function registered()
    {

    }
}
