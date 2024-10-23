<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colis;
use App\Models\Annonce;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DashboardGPController extends Controller
{
    // Voir toutes les annonces créées par le GP connecté
    public function mesAnnonces()
    {
        $gpId = Auth::id();
        $annonces = Annonce::where('createur', $gpId)->get();

        return response()->json($annonces, 200);
    }

    // Voir toutes les réservations liées aux annonces créées par le GP
    public function mesReservations()
    {
        $gpId = Auth::id();

        // Récupérer toutes les annonces créées par le GP
        $annoncesIds = Annonce::where('createur', $gpId)->pluck('id');

        // Récupérer toutes les réservations qui sont liées à ces annonces
        $reservations = Reservation::whereIn('annonce_id', $annoncesIds)->get();

        return response()->json($reservations, 200);
    }

    // Voir les détails des colis liés aux réservations d'une annonce
    public function detailsColisPourAnnonce($id)
    {
        $gpId = Auth::id();

        // Vérifier si l'annonce appartient au GP connecté
        $annonce = Annonce::where('id', $id)->where('createur', $gpId)->first();

        if (!$annonce) {
            return response()->json(['message' => 'Annonce non trouvée ou non autorisée.'], 404);
        }

        // Récupérer les réservations liées à l'annonce
        $reservations = Reservation::where('annonce_id', $id)
            ->with(['colis', 'user'])
            ->get();

        $nombreReservations = $reservations->count();

        // Préparer les détails des réservations et des colis
        $reservationsDetails = $reservations->map(function ($reservation) {
            return [
                'reservation_id' => $reservation->id,
                'user' => $reservation->user->nom ?? 'Utilisateur inconnu',
                'colis' => [
                    'colis_id' => $reservation->colis->id,
                    'description' => $reservation->colis->description,
                    'poids' => $reservation->colis->poids,
                    'dimensions' => $reservation->colis->dimensions,
                    'status' => $reservation->colis->status,
                ],
            ];
        });

        return response()->json([
            'annonce' => $annonce,
            'nombre_reservations' => $nombreReservations,
            'reservations_details' => $reservationsDetails,
        ], 200);
    }


    // Méthode pour afficher les colis liés à une annonce spécifique
    public function colisParAnnonce($annonceId)
    {
        $gpId = Auth::id();

        // Vérifier que l'annonce appartient au GP connecté
        $annonce = Annonce::where('id', $annonceId)->where('createur', $gpId)->first();

        if (!$annonce) {
            return response()->json(['message' => 'Annonce non trouvée ou non autorisée.'], 404);
        }

        // Récupérer les réservations liées à l'annonce
        $reservationsIds = Reservation::where('annonce_id', $annonceId)->pluck('id');

        // Récupérer les colis liés aux réservations de cette annonce
        $colis = Colis::whereIn('reservation_id', $reservationsIds)->get();

        if ($colis->isEmpty()) {
            return response()->json(['message' => 'Aucun colis trouvé pour cette annonce.'], 404);
        }

        // Préparer les détails des colis
        $colisDetails = $colis->map(function ($colis) {
            return [
                'colis_id' => $colis->id,
                'description' => $colis->description,
                'poids' => $colis->poids,
                'dimensions' => $colis->dimensions,
                'status' => $colis->status,
                'reservation_id' => $colis->reservation_id,
            ];
        });

        return response()->json([
            'annonce_id' => $annonceId,
            'colis' => $colisDetails
        ], 200);
    }

    // Méthode pour obtenir les statistiques sur les colis, annonces et réservations
    public function statistiques()
    {
        $gpId = Auth::id();

        // Récupérer toutes les annonces créées par le GP
        $annoncesIds = Annonce::where('createur', $gpId)->pluck('id');

        // Statistiques : Nombre d'annonces
        $nombreAnnonces = Annonce::where('createur', $gpId)->count();

        // Statistiques : Nombre de réservations liées à ces annonces
        $nombreReservations = Reservation::whereIn('annonce_id', $annoncesIds)->count();

        // Statistiques : Nombre de colis liés à ces réservations
        $reservationsIds = Reservation::whereIn('annonce_id', $annoncesIds)->pluck('id');

        // Compter les colis basés sur les réservations
        $nombreColis = Colis::whereIn('reservation_id', $reservationsIds)->count();

        // Retourner les statistiques sous forme de JSON
        return response()->json([
            'nombre_annonces' => $nombreAnnonces,
            'nombre_reservations' => $nombreReservations,
            'nombre_colis' => $nombreColis,
        ], 200);
    }

    // Ajouter cette méthode dans le DashboardGPController
    public function changerStatutReservation($id, Request $request)
    {
        $request->validate([
            'status' => 'required|string', // Assurez-vous que le statut est valide
        ]);

        try {
            $reservation = Reservation::findOrFail($id); // Trouver la réservation par ID
            $reservation->status = $request->input('status'); // Mettre à jour le statut
            $reservation->save(); // Enregistrer les changements

            return response()->json(['message' => 'Statut mis à jour avec succès.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Réservation non trouvée.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour du statut.', 'error' => $e->getMessage()], 500);
        }
    }


}
