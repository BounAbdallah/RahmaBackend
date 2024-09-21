<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarif extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Relation avec ZoneLivraison
    public function zoneLivraison()
    {
        return $this->belongsTo(ZoneLivraison::class);
    }
}
