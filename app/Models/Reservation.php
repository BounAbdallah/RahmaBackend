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

    // Relation : Une réservation peut avoir plusieurs colis
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function colis()
    {
        return $this->hasMany(Colis::class);
    }
}
