<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceManagementController extends Controller
{

    public function listeAnnonce()
    {
        // Récupère toutes les annonces créées par l'utilisateur connecté
        $annonces = Annonce::all();
        return response()->json($annonces);
    }



    public function showAnnonceDetails($id)
{
    // Récupérer l'annonce avec ses rôles
    $annonce = Annonce::with('status')->find($id);

    // Vérifier si l'annonce existe
    if (!$annonce) {
        return response()->json([
            'message' => 'Annonce non trouvé',
        ], 404);
    }

    // Retourner les détails de l'annonce
    return response()->json($annonce);
}
}
