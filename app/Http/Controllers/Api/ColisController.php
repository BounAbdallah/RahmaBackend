<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Colis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColisController extends Controller
{
    // Afficher une liste des colis pour l'utilisateur authentifié
    public function index()
    {
        $user = Auth::user();
        // Récupérer uniquement les colis créés par l'utilisateur connecté
        $colis = Colis::where('user_id', $user->id)->get();
        return response()->json($colis);
    }

    // Créer un nouveau colis (seulement les utilisateurs avec les rôles 'Client', 'GP', 'Admin', ou 'Gestionnaire' peuvent le faire)
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Not authenticated'], 403);
        }

        if (!$user->hasAnyRole(['Client', 'GP', 'Admin', 'Gestionnaire'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validation des données
        $request->validate([
            'titre' => 'required|string|max:255',
            'poids_kg' => 'required|numeric',
            'adresse_expediteur' => 'required|string',
            'adresse_destinataire' => 'required|string',
            'contact_destinataire' => 'required|string',
            'contact_expediteur' => 'required|string',
            'date_envoi' => 'required|date',
            'statut' => 'required|in:en transit,livré,en attente,retourné',
            'description' => 'nullable|string',
        ]);

        // Création du colis
        $colis = Colis::create([
            'user_id' => $user->id, // Associer l'utilisateur connecté
            'titre' => $request->titre,
            'poids_kg' => $request->poids_kg,
            'adresse_expediteur' => $request->adresse_expediteur,
            'adresse_destinataire' => $request->adresse_destinataire,
            'contact_destinataire' => $request->contact_destinataire,
            'contact_expediteur' => $request->contact_expediteur,
            'date_envoi' => $request->date_envoi,
            'statut' => $request->statut,
            'description' => $request->description,
        ]);

        return response()->json($colis, 201);
    }

    // Afficher les détails d'un colis spécifique, uniquement si l'utilisateur est le créateur
    public function show(Colis $colis)
    {
        $user = Auth::user();

        if ($colis->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($colis);
    }

    // Mettre à jour un colis, uniquement si l'utilisateur est le créateur
    public function update(Request $request, Colis $colis)
    {
        $user = Auth::user();

        if ($colis->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'poids_kg' => 'sometimes|required|numeric',
            'adresse_expediteur' => 'sometimes|required|string',
            'adresse_destinataire' => 'sometimes|required|string',
            'contact_destinataire' => 'sometimes|required|string',
            'contact_expediteur' => 'sometimes|required|string',
            'date_envoi' => 'sometimes|required|date',
            'statut' => 'sometimes|required|in:en transit,livré,en attente,retourné',
            'description' => 'nullable|string',
        ]);

        $colis->update($request->all());
        return response()->json($colis);
    }

    // Archiver un colis, uniquement si l'utilisateur est le créateur
    public function archive(Colis $colis)
    {
        $user = Auth::user();

        if ($colis->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Archiver le colis
        $colis->etat = 'archivé';
        $colis->save();

        return response()->json(['message' => 'Colis archived successfully']);
    }

    // Désarchiver un colis, uniquement si l'utilisateur est le créateur
    public function unarchive(Colis $colis)
    {
        $user = Auth::user();

        if ($colis->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Désarchiver le colis
        $colis->etat = 'desarchivé';
        $colis->save();

        return response()->json(['message' => 'Colis unarchived successfully']);
    }

    // Supprimer définitivement un colis, uniquement si l'utilisateur est le créateur ou un administrateur
    public function destroy(Colis $colis)
    {
        $user = Auth::user();

        if ($colis->user_id !== $user->id && !$user->hasRole('Admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $colis->forceDelete();
        return response()->json(['message' => 'Colis permanently deleted']);
    }
}
