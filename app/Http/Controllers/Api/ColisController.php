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

    // Créer un nouveau colis
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
            // 'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gestion de l'image du colis
        // $imagePath = 'assets/default-image.jpg'; // Valeur par défaut

        // if ($request->hasFile('image_1')) {
        //     // Stockage de l'image dans un dossier spécifique pour les colis
        //     $imagePath = $request->file('image_1')->store('colis_images', 'public');
        // }

        // Création du colis avec les informations et le chemin de l'image
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
            // 'image_1' => $imagePath, // Chemin de l'image du colis
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
            'date_envoi' => 'nullable|date',
            'statut' => 'sometimes|required|in:en transit,livré,en attente,retourné',
            'description' => 'nullable|string',
            // 'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gestion de l'image
        if ($request->hasFile('image_1')) {
            $imagePath = $request->file('image_1')->store('photo_profil', 'public');
            $request->merge(['image_1' => $imagePath]);
        }

        // Définir la date d'envoi à la date actuelle si elle n'est pas fournie
        if (empty($request->date_envoi)) {
            $request->merge(['date_envoi' => now()]);
        }

        // Mettre à jour le colis
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

    public function historique()
    {
        $user = Auth::user();

        // Récupérer tous les colis créés par l'utilisateur connecté avec leur statut
        $colis = Colis::where('user_id', $user->id)
                        ->select('id', 'titre', 'statut', 'date_envoi', 'description')
                        ->orderBy('date_envoi', 'desc')
                        ->get();

        return response()->json($colis);
    }
}
