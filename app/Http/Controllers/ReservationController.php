<?php

namespace App\Http\Controllers;

use App\Models\Colis;
use App\Models\Annonce;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Mail\ReservationCreatedMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationStatusChangedMail;
use App\Notifications\ReservationNotification;
use App\Notifications\ReservationStatusChangedNotification;

class ReservationController extends Controller
{
    // Liste toutes les réservations
    public function index()
    {
        $reservations = Reservation::with(['annonce', 'user', 'colis'])->get();
        return response()->json($reservations);
    }

    // Créer une nouvelle réservation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'colis_id' => 'nullable|exists:colis,id',
            'status' => 'in:confirmée,annulée,en attente',
            'date_reservation' => 'required|date',
        ]);

        if (isset($validated['colis_id'])) {
            $colis = Colis::findOrFail($validated['colis_id']);
            if ($colis->user_id !== Auth::id()) {
                return response()->json(['error' => 'Ce colis ne vous appartient pas.'], 403);
            }

            $existingReservation = Reservation::where('colis_id', $validated['colis_id'])->first();
            if ($existingReservation) {
                return response()->json(['error' => 'Ce colis est déjà associé à une réservation.'], 400);
            }
        }

        $validated['user_id'] = Auth::id();
        $reservation = Reservation::create($validated);

        // Associer le colis à la réservation si l'ID de colis est présent
        if (isset($validated['colis_id'])) {
            $reservation->colis_id = $validated['colis_id']; // Assignation directe
            $reservation->save(); // Sauvegarder la réservation avec le colis associé
        }

        // Envoyer un e-mail au créateur de l'annonce
        Mail::to($reservation->annonce->user->email)->send(new ReservationCreatedMail($reservation));

        // Envoyer un e-mail à l'utilisateur ayant fait la réservation
        Mail::to($reservation->user->email)->send(new ReservationCreatedMail($reservation));

        // Stocker une notification dans la base de données pour le créateur de l'annonce
        $reservation->annonce->user->notify(new ReservationNotification($reservation, 'Une nouvelle réservation a été effectuée pour votre annonce.'));

        // Stocker une notification dans la base de données pour l'utilisateur ayant fait la réservation
        $reservation->user->notify(new ReservationNotification($reservation, 'Vous avez fait une nouvelle réservation.'));

        // Charger les colis associés
        $reservation->load('colis');
        return response()->json($reservation, 201);
    }

    // Afficher une réservation spécifique
    public function show($id)
    {
        $reservation = Reservation::with(['annonce', 'user', 'colis'])->find($id);

        // Vérifier si la réservation existe
        if (!$reservation) {
            return response()->json(['message' => 'Réservation non trouvée.'], 404);
        }

        return response()->json($reservation);
    }

    // Afficher les détails d'une réservation spécifique avec le nombre total de colis et le poids total
    public function showWithColisDetails($id)
    {
        // Récupérer la réservation avec ses colis
        $reservation = Reservation::with(['colis' => function($query) {
            $query->withTrashed(); // Inclure les colis supprimés logiquement si applicable
        }])->findOrFail($id);

        // Vérification des colis
        if ($reservation->colis_id === null) {
            return response()->json(['error' => 'Aucun colis associé à cette réservation.'], 404);
        }

        // Calculer le nombre total de colis et le poids total
        $totalColis = 1; // Puisqu'il ne peut y avoir qu'un seul colis associé
        $totalPoids = $reservation->colis->poids_kg; // Assurez-vous que 'poids_kg' est le nom correct de la colonne dans votre table Colis

        // Préparer la réponse
        $response = [
            'reservation' => $reservation,
            'total_colis' => $totalColis,
            'total_poids' => $totalPoids,
        ];

        return response()->json($response);
    }

    // Mettre à jour une réservation existante
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $validated = $request->validate([
            'status' => 'in:confirmée,annulée,en attente',
            'date_reservation' => 'date',
            'colis_id' => 'nullable|exists:colis,id',
        ]);

        if (isset($validated['colis_id'])) {
            $colis = Colis::findOrFail($validated['colis_id']);
            if ($colis->user_id !== Auth::id()) {
                return response()->json(['error' => 'Ce colis ne vous appartient pas.'], 403);
            }

            $existingReservation = Reservation::where('colis_id', $validated['colis_id'])
                ->where('id', '!=', $id)
                ->first();

            if ($existingReservation) {
                return response()->json(['error' => 'Ce colis est déjà associé à une autre réservation.'], 400);
            }

            // Associer le colis à la réservation si l'ID de colis est présent
            $reservation->colis_id = $validated['colis_id']; // Assignation directe
        }

        // Vérifier si le statut a changé avant la mise à jour
        $oldStatus = $reservation->status;
        $reservation->update($validated);
        $reservation->load('colis');

        // Si le statut a changé, envoyer des notifications
        if (isset($validated['status']) && $validated['status'] !== $oldStatus) {
            // Envoi des notifications par e-mail
            Mail::to($reservation->annonce->user->email)->send(new ReservationStatusChangedMail($reservation, $validated['status']));
            Mail::to($reservation->user->email)->send(new ReservationStatusChangedMail($reservation, $validated['status']));

            // Notifications de changement de statut
            $reservation->annonce->user->notify(new ReservationStatusChangedNotification($reservation, $validated['status']));
            $reservation->user->notify(new ReservationStatusChangedNotification($reservation, $validated['status']));
        }

        return response()->json($reservation);
    }

    // Supprimer une réservation
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return response()->json(['message' => 'Réservation supprimée avec succès.'], 204);
    }

    // Mise à jour du statut d'une réservation
    public function updateStatus(Request $request, $reservationId)
    {
        // Validation du statut
        $request->validate([
            'status' => 'required|string|in:confirmée,annulée,en attente'
        ]);

        // Récupérer la réservation
        $reservation = Reservation::findOrFail($reservationId);

        // Mise à jour du statut
        $oldStatus = $reservation->status;
        $reservation->status = $request->status;
        $reservation->save();

        // Envoi des notifications par e-mail
        Mail::to($reservation->annonce->user->email)->send(new ReservationStatusChangedMail($reservation, $request->status));
        Mail::to($reservation->user->email)->send(new ReservationStatusChangedMail($reservation, $request->status));

        // Stocker une notification dans la base de données pour le créateur de l'annonce
        $reservation->annonce->user->notify(new ReservationStatusChangedNotification($reservation, $request->status));

        // Stocker une notification dans la base de données pour l'utilisateur ayant fait la réservation
        $reservation->user->notify(new ReservationStatusChangedNotification($reservation, $request->status));

        return response()->json(['message' => 'Statut mis à jour avec succès et notifications envoyées.']);
    }

    // Afficher le poids total des colis liés à une réservation
    public function totalPoidsColis($reservationId)
    {
        // Récupérer la réservation avec ses colis
        $reservation = Reservation::with('colis')->findOrFail($reservationId);

        // Vérifier si la réservation a des colis associés
        if ($reservation->colis_id === null) {
            return response()->json(['error' => 'Aucun colis associé à cette réservation.'], 404);
        }

        // Calculer le poids total des colis liés à cette réservation
        $totalPoids = $reservation->colis->poids_kg; // Assurez-vous que 'poids_kg' est le nom correct de la colonne dans votre table Colis

        return response()->json(['total_poids' => $totalPoids]);
    }
}
