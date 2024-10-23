<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colis extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Relation : Un colis appartient à un utilisateur (expéditeur)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation : Un colis est lié à une réservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    // Relation : Un colis peut être lié à un paiement
    public function paiement()
    {
        return $this->hasMany(Paiement::class);
    }
}
