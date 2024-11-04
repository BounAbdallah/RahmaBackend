<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotationController extends Controller
{
    // Affiche la liste des notations
    public function index()
    {
        $notations = Notation::with('user', 'annonce')->get();
        return response()->json($notations, Response::HTTP_OK);
    }

    // Enregistre une nouvelle notation
    public function store(Request $request)
    {
        $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
        ]);

        // Vérifiez si l'utilisateur a une réservation pour une annonce du même créateur
        $reservation = \App\Models\Reservation::where('user_id', auth()->id())
                        ->whereHas('annonce', function ($query) use ($request) {
                            $query->where('id', $request->annonce_id);
                        })
                        ->first();

        if (!$reservation || $reservation->annonce->createur != auth()->id()) {
            // Récupérer les créateurs des annonces sur lesquelles l'utilisateur a réservé
            $reservedAnnonces = \App\Models\Reservation::where('user_id', auth()->id())
                                ->with('annonce')
                                ->get()
                                ->pluck('annonce.createur')
                                ->unique();

            return response()->json([
                'message' => 'Vous ne pouvez noter cette annonce que si elle appartient à un créateur pour lequel vous avez déjà réservé.',
                'createurs_reserves' => $reservedAnnonces
            ], Response::HTTP_FORBIDDEN);
        }

        // Crée la notation si l'utilisateur a déjà réservé pour une annonce du même créateur
        $notation = Notation::create([
            'user_id' => auth()->id(),
            'annonce_id' => $request->annonce_id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return response()->json([
            'message' => 'Notation créée avec succès.',
            'notation' => $notation
        ], Response::HTTP_CREATED);
    }




    // Affiche une notation spécifique
    public function show(Notation $notation)
    {
        return response()->json($notation, Response::HTTP_OK);
    }

    // Met à jour une notation
    public function update(Request $request, Notation $notation)
    {
        $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
        ]);

        // Vérifie que l'utilisateur connecté est le propriétaire de la notation
        if ($notation->user_id !== auth()->id()) {
            return response()->json(['message' => 'Non autorisé.'], Response::HTTP_FORBIDDEN);
        }

        $notation->update([
            'annonce_id' => $request->annonce_id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return response()->json([
            'message' => 'Notation mise à jour avec succès.',
            'notation' => $notation
        ], Response::HTTP_OK);
    }

    // Supprime une notation
    public function destroy(Notation $notation)
    {
        // Vérifie que l'utilisateur connecté est le propriétaire de la notation
        if ($notation->user_id !== auth()->id()) {
            return response()->json(['message' => 'Non autorisé.'], Response::HTTP_FORBIDDEN);
        }

        $notation->delete();

        return response()->json([
            'message' => 'Notation supprimée avec succès.'
        ], Response::HTTP_NO_CONTENT);
    }
}
