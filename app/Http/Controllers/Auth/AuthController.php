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
    #SE DECONNECTER
    public function logout()
    {
        auth()->logout();
        return redirect()->route('screenLogin');
    }
}