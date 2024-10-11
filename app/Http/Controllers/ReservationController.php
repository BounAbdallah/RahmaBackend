<?php
namespace App\Http\Controllers;

use App\Models\Colis;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Mail\ReservationCreatedMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    // Liste toutes les réservations
    public function index()
    {
        // Charger la relation 'colis' pour chaque réservation
        $reservations = Reservation::with('annonce', 'user', 'colis')->get();

        // Retourner les données en JSON
        return response()->json($reservations);
    }

    // Créer une nouvelle réservation
    public function store(Request $request)
    {
        // Valider les champs de la requête
        $validated = $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'colis_id' => 'nullable|exists:colis,id',
            'status' => 'in:confirmée,annulée,en attente',
            'date_reservation' => 'required|date',
        ]);

        // Vérifier que le colis appartient à l'utilisateur connecté
        if (isset($validated['colis_id'])) {
            $colis = Colis::findOrFail($validated['colis_id']);
            if ($colis->user_id !== Auth::id()) {
                return response()->json(['error' => 'Ce colis ne vous appartient pas.'], 403);
            }

            // Vérifier si le colis est déjà associé à une réservation
            $existingReservation = Reservation::where('colis_id', $validated['colis_id'])->first();
            if ($existingReservation) {
                return response()->json(['error' => 'Ce colis est déjà associé à une réservation.'], 400);
            }
        }

        // Ajouter l'ID de l'utilisateur connecté
        $validated['user_id'] = Auth::id();

        // Créer la réservation
        $reservation = Reservation::create($validated);

        // Charger la relation 'colis' après la création de la réservation
        $reservation->load('colis');

        // Récupérer les emails du créateur de l'annonce et de l'utilisateur ayant réservé
        $annonceCreatorEmail = $reservation->annonce->user->email;
        $reservingUserEmail = $reservation->user->email;

        // Envoyer l'email au créateur de l'annonce
        Mail::to($annonceCreatorEmail)->send(new ReservationCreatedMail($reservation));

        // Envoyer l'email à l'utilisateur ayant fait la réservation
        Mail::to($reservingUserEmail)->send(new ReservationCreatedMail($reservation));

        // Retourner la réservation avec le colis associé
        return response()->json($reservation, 201);
    }

    // Afficher une réservation spécifique
    public function show($id)
    {
        // Charger la relation 'colis' pour la réservation
        $reservation = Reservation::with('annonce', 'user', 'colis')->findOrFail($id);

        // Vérifier si un colis est associé à la réservation
        if ($reservation->colis) {
            return response()->json($reservation);
        } else {
            // Si aucun colis n'est associé, retourner un message spécifique
            return response()->json(['reservation' => $reservation, 'message' => 'Aucun colis associé.']);
        }
    }

    // Mettre à jour une réservation existante
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        // Valider les données de mise à jour
        $validated = $request->validate([
            'status' => 'in:confirmée,annulée,en attente',
            'date_reservation' => 'date',
            'colis_id' => 'nullable|exists:colis,id',
        ]);

        // Vérifier que le colis appartient à l'utilisateur connecté
        if (isset($validated['colis_id'])) {
            $colis = Colis::findOrFail($validated['colis_id']);

            // Vérifier que le colis appartient à l'utilisateur connecté
            if ($colis->user_id !== Auth::id()) {
                return response()->json(['error' => 'Ce colis ne vous appartient pas.'], 403);
            }

            // Vérifier si le colis est déjà associé à une autre réservation (autre que la réservation actuelle)
            $existingReservation = Reservation::where('colis_id', $validated['colis_id'])
                ->where('id', '!=', $id)
                ->first();

            if ($existingReservation) {
                return response()->json(['error' => 'Vous ne pouez pas réserver un pour un colis déjà enregistre dans une autre reservation.'], 400);
            }
        }

        // Mettre à jour la réservation
        $reservation->update($validated);

        // Charger la relation 'colis' après mise à jour
        $reservation->load('colis');

        // Retourner la réservation mise à jour
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

        // Valider le statut
        $validated = $request->validate([
            'status' => 'required|in:confirmée,annulée,en attente',
        ]);

        // Mettre à jour uniquement le statut
        $reservation->update($validated);

        return response()->json($reservation);
    }
}
