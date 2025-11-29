<?php

namespace App\Repository;

use Illuminate\Support\Facades\Auth;

class  AuhRepository
{
    public function login($user_email, $password)
    {
        return Auth::attempt(['email'=> $user_email, 'password'=>$password]);
    }
}