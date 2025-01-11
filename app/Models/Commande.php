<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function livraisons()
    {
        return $this->hasMany(Livraison::class);
    }
}
