<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class Setting
{
    #Génère un UUID unique
    public function generateUuid(): string
    {
        return Str::uuid()->toString();
    }


    #Hash un mot de passe
    public function hashPassword(string $password): string
    {
        return Hash::make($password);
    }
}