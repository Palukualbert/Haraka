<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Chauffeur extends Authenticatable
{
    protected $fillable = ['telephone', 'disponible'];

    public function vehicules()
    {
        return $this->hasMany(Vehicule::class);
    }
}



