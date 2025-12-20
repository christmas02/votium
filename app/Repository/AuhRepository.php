<?php

namespace App\Repository;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class  AuhRepository
{
    public function login($user_email, $password)
    {
        return Auth::attempt(['email'=> $user_email, 'password'=>$password]);
    }

    public function makeResetPassword($user_email, $password)
    {
        try {
            $user = User::where('email', $user_email)->first();
            if ($user) {
                $user->password = $password;
                return $user->save();
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la reinitialisation du mot de passe : '.$e->getMessage());
            return false;
        }
    }

    public function saveUser($dataUser){
        try{
        $user = new User();
        $user->user_id = $dataUser['user_id'];
        $user->name = $dataUser['name'];
        $user->phonenumber = $dataUser['phonenumber'];
        $user->email = $dataUser['email'];
        $user->role = $dataUser['role'];
        $user->password = $dataUser['password'];

        $user->save();

        }  catch (\Exception $e) {
          \Log::error('Erreur lors de la sauvegarde du client : '.$e->getMessage());
          return false;
        }
    }

    public function updateUser($dataUser)
    {
        try {
            $user = User::where('user_id', $dataUser['user_id'])->first();
            // TO DO UPDATE USER INFO
            $user->name = $dataUser['name'];
            $user->phonenumber = $dataUser['phonenumber'];
            $user->email = $dataUser['email'];
            if (isset($dataUser['password']) && !empty($dataUser['password'])) {
                $user->password = $dataUser['password'];
            }
            return $user->save();
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour de l\'utilisateur : ' . $e->getMessage());
            return false;
        }
    }
}