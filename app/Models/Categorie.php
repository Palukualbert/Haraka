<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['nomCategorie'];

    public function vehicule()
    {
        return $this->hasMany(Vehicule::class);
    }
}
