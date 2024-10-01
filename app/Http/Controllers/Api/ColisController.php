<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Colis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColisController extends Controller
{
    // Afficher une liste des colis
    public function index()
    {
        // Permet à tout utilisateur authentifié de voir les colis
        $colis = Colis::all();
        return response()->json($colis);
    }

    // Créer un nouveau colis (seulement les utilisateurs avec les rôles 'Client', 'GP', 'Admin', ou 'Gestionnaire' peuvent le faire)
    public function store(Request $request)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur est authentifié
        if (!$user) {
            return response()->json(['message' => 'not authenticated'], 403);
        }

        // Vérification de rôle
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
            'user_id' => $user->id,
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

    // Afficher les détails d'un colis spécifique
    public function show(Colis $colis)
    {
        return response()->json($colis);
    }

    // Mettre à jour un colis (seulement les utilisateurs avec les rôles 'Client', 'GP', 'Admin' ou 'Gestionnaire' peuvent modifier)
    public function update(Request $request, Colis $colis)
    {
        // Vérification de rôle
        if (!Auth::user()->hasAnyRole(['Client', 'GP', 'Admin', 'Gestionnaire'])) {
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

    // Archiver un colis (seulement les utilisateurs avec les rôles 'Client', 'GP', 'Admin', ou 'Gestionnaire' peuvent archiver)
    public function archive(Colis $colis)
    {
        // Vérification de rôle
        if (!Auth::user()->hasAnyRole(['Client', 'GP', 'Admin', 'Gestionnaire'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Archiver le colis (vous pouvez ajouter votre logique ici pour changer le statut)
        $colis->statut = 'archivé'; // Exemples de statut, à adapter selon votre logique
        $colis->save();

        return response()->json(['message' => 'Colis archived successfully']);
    }

    // Désarchiver un colis (seulement les utilisateurs avec les rôles 'Client', 'GP', 'Admin', ou 'Gestionnaire' peuvent désarchiver)
    public function unarchive(Colis $colis)
    {
        // Vérification de rôle
        if (!Auth::user()->hasAnyRole(['Client', 'GP', 'Admin', 'Gestionnaire'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Désarchiver le colis (vous pouvez ajouter votre logique ici pour changer le statut)
        $colis->statut = 'en attente'; // Exemples de statut, à adapter selon votre logique
        $colis->save();

        return response()->json(['message' => 'Colis unarchived successfully']);
    }

    // Supprimer définitivement un colis (seulement les utilisateurs avec le rôle 'Admin' peuvent faire cela)
    public function destroy(Colis $colis)
    {
        // Vérification de rôle
        if (!Auth::user()->hasRole('Admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $colis->forceDelete();
        return response()->json(['message' => 'Colis permanently deleted']);
    }
}
