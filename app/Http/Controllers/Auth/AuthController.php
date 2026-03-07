<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController  extends Controller
{
    public function screenLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $inputVal = $request->all();

            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (auth()->attempt(array('email' => $inputVal['email'], 'password' => $inputVal['password']))) {
                if (auth()->user()->role == "admin") {
                    return redirect()->route('console.espace');
                }elseif(auth()->user()->role == "customer"){
                    return redirect()->route('business.espace');
                }else{
                    return redirect()->route('screenLogin');
                }
            } else {
                //dd('Infromation invalide, veiller contacter notre service');
                return redirect('/')->with('error', 'Vos accès sont invalides, veuillez réessayer avec les bons identifiants.');
            }

        } catch (\Throwable $th){
            Log::error($th->getMessage());
            return redirect('/')->with('error','Infromation invalide, veiller contacter notre service');
        }
    }

    #AFFICHER LE FORMULAIRE D'INSCRIPTION
    public function screenRegister()
    {
        return view('auth.inscription');
    }

    #création de compte
    public function register(Request $request)
    {
        try {
            $inputVal = $request->all();

            $this->validate($request, [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);

            $user = new \App\Models\User();
            $user->name = $inputVal['name'];
            $user->phone = $inputVal['phone'];
            $user->email = $inputVal['email'];
            $user->password = bcrypt($inputVal['password']);
            $user->save();

            return redirect()->route('screenLogin')->with('success', 'Votre compte a été créé avec succès. Veuillez vous connecter.');

        } catch (\Throwable $th){
            Log::error($th->getMessage());
            return redirect()->route('screenLogin')->with('error','Une erreur est survenue lors de la création de votre compte. Veuillez réessayer.');
        }
    }

    #AFFICHER LE FORMULAIRE DE MOT DE PASSE OUBLIÉ
    public function screenForgot()
    {
        return view('auth.forgot');
    }

    #AFFICHER LE FORMULAIRE DE RÉINITIALISATION DU MOT DE PASSE
    public function screenReset($token)
    {
        return view('auth.reset', compact('token'));
    }

    #RÉINITIALISER LE MOT DE PASSE
    public function reset(Request $request)
    {
        try {
            $inputVal = $request->all();

            $this->validate($request, [
                'password' => 'required|confirmed|min:6',
            ]);

            $user = \App\Models\User::where('email', $inputVal['email'])->first();
            if ($user) {
                $user->password = bcrypt($inputVal['password']);
                $user->save();
                return redirect()->route('screenLogin')->with('success', 'Votre mot de passe a été réinitialisé avec succès.');
            } else {
                return redirect()->route('screenReset', ['token' => $inputVal['token']])->with('error', 'Une erreur est survenue. Veuillez réessayer.');
            }

        } catch (\Throwable $th){
            Log::error($th->getMessage());
            return redirect()->route('screenReset', ['token' => $inputVal['token']])->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    #SE DECONNECTER
    public function logout()
    {
        auth()->logout();
        return redirect()->route('screenLogin');
    }
}