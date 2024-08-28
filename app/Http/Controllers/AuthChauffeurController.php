<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnChauffRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthChauffeurController extends Controller
{
    public function login(){
        return view('layouts.connChauff');
    }

    public function auth(ConnChauffRequest $request){

        if (Auth::guard('chauffeur')->attempt(['telephone' => $request->telephone, 'mot_de_passe' => $request->mot_de_passe])) {
            dd('Authentification reussi !');
            return redirect()->intended('/chauffeur/dashboard');
        }else{
            dd('Authentification echoueé !');
        }


    }
}
