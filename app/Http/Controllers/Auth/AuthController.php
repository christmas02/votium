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
            //dd($request->all());
            $inputVal = $request->all();

            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (auth()->attempt(array('email' => $inputVal['email'], 'password' => $inputVal['password']))) {
                if (auth()->user()->role == "admin") {
                    return redirect()->route('back_office_console');
                }elseif(auth()->user()->role == "customer"){
                    return redirect()->route('back_office_business');
                }else{
                    return redirect()->route('screenLogin');
                }
            } else {
                //dd('Infromation invalide, veiller contacter notre service');
                return redirect('authentification')->with('error', 'Infromation invalide, veiller contacter notre service');
            }

        } catch (\Throwable $th){
            dd($th->getMessage());
            Log::error($th->getMessage());
            return redirect('error')->with('error','Infromation invalide, veiller contacter notre service');
        }
    }
    #SE DECONNECTER
    public function logout()
    {
        auth()->logout();
        return redirect()->route('screenLogin');
    }
}