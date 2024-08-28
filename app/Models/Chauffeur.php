<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chauffeur extends Model
{
    protected $fillable = ['telephone', 'disponible'];

    public function vehicules()
    {
        return $this->hasMany(Vehicule::class);
    }
}



