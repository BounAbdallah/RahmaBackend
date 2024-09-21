<?php
namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // Liste toutes les réservations
    public function index()
    {
        $reservations = Reservation::with('annonce', 'user')->get();
        return response()->json($reservations);
    }

    // Créer une nouvelle réservation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'in:confirmée,annulée,en attente',
            'date_reservation' => 'required|date',
        ]);

        $reservation = Reservation::create($validated);
        return response()->json($reservation, 201);
    }

    // Afficher une réservation spécifique
    public function show($id)
    {
        $reservation = Reservation::with('annonce', 'user')->findOrFail($id);
        return response()->json($reservation);
    }

    // Mettre à jour une réservation existante
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $validated = $request->validate([
            'status' => 'in:confirmée,annulée,en attente',
            'date_reservation' => 'date',
        ]);

        $reservation->update($validated);
        return response()->json($reservation);
    }

    // Supprimer une réservation
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return response()->json(null, 204);
    }

    // Mise à jour du statut d'une réservation
    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:confirmée,annulée,en attente',
        ]);

        $reservation->update($validated);
        return response()->json($reservation);
    }
}
