<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reservation';
    protected $guarded = [];

    // Relation : Une réservation appartient à une annonce
    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    // Relation : Une réservation appartient à un utilisateur (client)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation : Une réservation appartient à un utilisateur  colis
    public function colis()
    {
        return $this->belongsTo(Colis::class);
    }
}
