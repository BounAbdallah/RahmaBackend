<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Colis;
use App\Models\Reservation;
use App\Models\Livraison;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    // Affiche toutes les activités du Client (colis, réservations, livraisons)
    public function dashboard()
    {
        $user = Auth::user();

        // Vérification si l'utilisateur est authentifié et s'il a le rôle Client
        if (!$user || !$user->hasRole('Client')) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        // Obtenir uniquement les colis, réservations et livraisons appartenant à l'utilisateur
        $colis = Colis::where('user_id', $user->id)->get();
        $reservations = Reservation::where('user_id', $user->id)->get();
        $livraisons = Livraison::where('client_id', $user->id)->get();

        // Vérifier si l'utilisateur n'a pas de colis
        if ($colis->isEmpty()) {
            return response()->json([
                'message' => 'Vous n\'avez aucun colis créé pour le moment.',
                'reservations' => $reservations,
                'livraisons' => $livraisons
            ]);
        }

        // Retourner les données du tableau de bord avec les colis, réservations et livraisons
        return response()->json([
            'colis' => $colis,
            'reservations' => $reservations,
            'livraisons' => $livraisons
        ]);
    }


    // Modifier un colis (seulement les colis appartenant à l'utilisateur)
    public function updateColis(Request $request, $id)
    {
        $user = Auth::user();

        // Vérification si l'utilisateur est authentifié et s'il a le rôle Client
        if (!$user || !$user->hasRole('Client')) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        $colis = Colis::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'titre' => 'sometimes|string|max:255',
            'poids_kg' => 'sometimes|numeric',
            'adresse_expediteur' => 'sometimes|string',
            'adresse_destinataire' => 'sometimes|string',
            'contact_destinataire' => 'sometimes|string',
            'contact_expediteur' => 'sometimes|string',
            'date_envoi' => 'sometimes|date',
            'statut' => 'sometimes|in:en transit,livré,en attente,retourné',
            'description' => 'nullable|string',
        ]);

        $colis->update($request->all());
        return response()->json($colis);
    }

    // Archiver un colis
    public function archiveColis($id)
    {
        $user = Auth::user();

        // Vérification si l'utilisateur est authentifié et s'il a le rôle Client
        if (!$user || !$user->hasRole('Client')) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        $colis = Colis::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $colis->statut = 'archivé';
        $colis->save();

        return response()->json(['message' => 'Colis archivé avec succès']);
    }

    // Désarchiver un colis
    public function unarchiveColis($id)
    {
        $user = Auth::user();

        // Vérification si l'utilisateur est authentifié et s'il a le rôle Client
        if (!$user || !$user->hasRole('Client')) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        $colis = Colis::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $colis->statut = 'en attente';
        $colis->save();

        return response()->json(['message' => 'Colis désarchivé avec succès']);
    }

    // Modifier une réservation
    public function updateReservation(Request $request, $id)
    {
        $user = Auth::user();

        // Vérification si l'utilisateur est authentifié et s'il a le rôle Client
        if (!$user || !$user->hasRole('Client')) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        $reservation = Reservation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'status' => 'in:confirmée,annulée,en attente',
            'date_reservation' => 'date',
        ]);

        $reservation->update($request->all());
        return response()->json($reservation);
    }

    // Modifier une livraison
    public function updateLivraison(Request $request, $id)
    {
        $user = Auth::user();

        // Vérification si l'utilisateur est authentifié et s'il a le rôle Client
        if (!$user || !$user->hasRole('Client')) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        $livraison = Livraison::where('id', $id)->where('client_id', $user->id)->firstOrFail();

        $request->validate([
            'statut' => 'in:livrée,en transit,en attente,annulée',
        ]);

        $livraison->update($request->all());
        return response()->json($livraison);
    }
}
