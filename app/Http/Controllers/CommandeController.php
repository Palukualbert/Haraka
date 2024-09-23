<?php

namespace App\Http\Controllers;

use App\Events\CommandeEnregistree;
use App\Models\Chauffeur;
use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function commande(){
        return view('layouts.commande');
    }

    public function submit(Request $request)
    {
        // Récupérer les données du formulaire
        $distance = $request->input('distance');
        $duration = $request->input('duration');
        $request->input('price');

        $chauffeurs = Chauffeur::where('disponible',1)->get();

        // Séparer les coordonnées
        list($startLat, $startLng) = explode(',', $request->input('startCoords'));
        list($endLat, $endLng) = explode(',', $request->input('endCoords'));
        $commande = Commande::create([
            'statut'=> false,
            'pointDepart' => $request->input('start'),
            'destination' => $request->input('end'),
            'coutEstime'=> $request->input('price'),
            'longitudeDepart'=> $startLng,
            'longitudeDest' => $endLng,
            'latitudeDepart'=> $startLat,
            'latitudeDest' => $endLat,
            'client_id' => 1,
            'vehicule_id' => 2

        ]);
        event(new CommandeEnregistree($commande));
        //envoi de du push notification au chauffeur

        // Traiter les données ici, par exemple, en les sauvegardant dans la base de données

        // Rediriger vers une page de confirmation ou afficher un message de succès
        return redirect()->route('order.success')->with('message', 'Commande réussie');
    }
}
