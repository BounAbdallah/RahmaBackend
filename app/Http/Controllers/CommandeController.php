<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
public function index()
    {
    // Vérifier si l'utilisateur est authentifié
    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => 'Vous devez être connecté pour accéder à cette ressource.',
        ], 401);
    }

    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Vérifier si l'utilisateur a le rôle admin ou gestionnaire
    if (!$user->hasRole(['Admin', 'Gestionnaire'])) {
        return response()->json([
            'success' => false,
            'message' => 'Accès non autorisé.',
        ], 403);
    }

    // Récupérer toutes les commandes
    $commandes = Commande::all();

    // Réponse JSON
    return response()->json([
        'success' => true,
        'commandes' => $commandes,
    ], 200);
}

public function show($id)
{
    // Vérifier si l'utilisateur est authentifié
    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => 'Vous devez être connecté pour accéder à cette ressource.',
        ], 401);
    }

    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Vérifier si l'utilisateur a le rôle admin ou gestionnaire
    if (!$user->hasRole(['Admin', 'Gestionnaire'])) {
        return response()->json([
            'success' => false,
            'message' => 'Accès non autorisé.',
        ], 403);
    }

    // Trouver la commande par ID
    $commande = Commande::find($id);

    if (!$commande) {
        return response()->json([
            'success' => false,
            'message' => 'Commande introuvable.',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'commande' => $commande,
    ], 200);
}

}