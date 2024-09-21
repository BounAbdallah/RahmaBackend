<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Livraison extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Vous pouvez définir les relations si nécessaire, par exemple :
    public function livreur()
    {
        return $this->belongsTo(User::class, 'livreur_id');
    }

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function gp()
    {
        return $this->belongsTo(User::class, 'gp_id');
    }

    public function colis()
    {
        return $this->belongsTo(Colis::class, 'colis_id');
    }

    public function zoneLivraison()
    {
        return $this->belongsTo(ZoneLivraison::class, 'zone_livraison_id');
    }
}
