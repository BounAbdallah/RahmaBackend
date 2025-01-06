<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneLivraison extends Model
{
    use HasFactory;
    // protected $table = 'zone_livraisons';
    // protected $fillable = ['libelle', 'description', 'arrondissement_id', 'arrondissement2_id'];

    protected $guarded = [];
    public function arrondissement()
    {
        return $this->belongsTo(Arondissement::class);
    }
}



