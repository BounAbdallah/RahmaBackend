<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];


    // Relation avec le colis
    public function colis()
    {
        return $this->belongsTo(Colis::class);
    }

    // Relation avec la livraison
    public function livraison()
    {
        return $this->belongsTo(Livraison::class);
    }

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
