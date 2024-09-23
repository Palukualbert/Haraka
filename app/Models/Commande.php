<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'statut', 'pointDepart', 'destination', 'coutEstime', 'longitudeDepart', 'longitudeDest', 'latitudeDepart', 'latitudeDest', 'client_id', 'vehicule_id'
    ];

}
