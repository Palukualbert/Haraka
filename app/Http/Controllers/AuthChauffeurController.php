<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnChauffRequest;
use App\Models\Chauffeur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthChauffeurController extends Controller
{
    public function login(){
        return view('layouts.connChauff');
    }

    public function auth(ConnChauffRequest $request){

        $credentials = [
            'telephone' => $request->telephone,
            'password' => $request->mot_de_passe  // Mapper "mot_de_passe" à "password"
        ];

        if (Auth::guard('chauffeur')->attempt($credentials)) {

            $chauffeur_id = Auth::user()->id;

            Chauffeur::where('id',$chauffeur_id)
                ->update(['disponible'=>1]);

            return redirect()->intended('/accepter');
        }

        return to_route('chauffeur.login')->withErrors(['fail'=>'Aucun chauffeur trouvé']);
    }
}
