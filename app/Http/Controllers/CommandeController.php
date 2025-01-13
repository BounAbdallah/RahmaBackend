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


public function store(Request $request)
    {
        // Vérification de l'authentification
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous devez être connecté pour accéder à cette ressource.',
            ], 401);
        }

        // Validation des données
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'status' => 'required|in:en_attente,approuver,desaprouver,attribuer_au_livreur,en_route,livrer',
            'type_livraison' => 'required|in:Livraison standard,Livraison express,Livraison domicile,Livraison sur_demande',
            'jour_livraison' => 'nullable|date',
            'heure_livraison' => 'nullable|date_format:H:i',
            'adresse_destinateur' => 'required|string|max:255',
            'description' => 'required|string',
            'message' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'colis_id' => 'nullable|exists:colis,id',
        ]);

        // Création de la commande
        $commande = Commande::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Commande créée avec succès.',
            'commande' => $commande,
        ], 201);
    }

    /**
     * Modifier une commande existante.
     */
    public function update(Request $request, $id)
    {
        // Vérification de l'authentification
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous devez être connecté pour accéder à cette ressource.',
            ], 401);
        }

        // Récupérer la commande
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande introuvable.',
            ], 404);
        }

        // Validation des données
        $validatedData = $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|in:en_attente,approuver,desaprouver,attribuer_au_livreur,en_route,livrer',
            'type_livraison' => 'sometimes|required|in:Livraison standard,Livraison express,Livraison domicile,Livraison sur_demande',
            'jour_livraison' => 'nullable|date',
            'heure_livraison' => 'nullable|date_format:H:i',
            'adresse_destinateur' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'message' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'colis_id' => 'nullable|exists:colis,id',
        ]);

        // Mise à jour de la commande
        $commande->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Commande mise à jour avec succès.',
            'commande' => $commande,
        ], 200);
    }

}
