<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Annonce extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Relation : Une annonce est créée par un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'createur');
    }

    // Relation : Une annonce peut avoir plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
