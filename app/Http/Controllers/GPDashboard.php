<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Reservation;
use App\Models\Colis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // Voir les détails des colis liés aux réservations
    public function detailsColisPourAnnonce($annonceId)
    {
        // Récupérer l'ID du GP connecté
        $gpId = Auth::id();

        // Vérifier que l'annonce appartient au GP connecté
        $annonce = Annonce::where('id', $annonceId)->where('createur', $gpId)->first();

        // Si l'annonce n'existe pas ou ne appartient pas à l'utilisateur connecté, renvoyer une erreur 404
        if (!$annonce) {
            return response()->json(['message' => 'Annonce non trouvée ou vous n\'êtes pas autorisé à accéder à cette annonce.'], 404);
        }

        // Récupérer les réservations liées à cette annonce
        $reservations = Reservation::where('annonce_id', $annonceId)->pluck('id');

        // Récupérer tous les colis liés à ces réservations
        $colis = Colis::whereIn('reservation_id', $reservations)->get();

        // Retourner les détails des colis
        return response()->json($colis, 200);
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

    // Détails d'une annonce avec nombre de réservations et détails des colis liés
    public function show($id)
    {
        $gpId = Auth::id();

        // Récupérer l'annonce avec le créateur correspondant
        $annonce = Annonce::where('id', $id)->where('createur', $gpId)->first();

        if (!$annonce) {
            return response()->json(['message' => 'Annonce non trouvée ou vous n\'êtes pas autorisé à accéder à cette annonce.'], 404);
        }

        // Récupérer les réservations liées à cette annonce
        $reservations = Reservation::where('annonce_id', $id)->get();

        // Récupérer les IDs des réservations pour récupérer les colis correspondants
        $reservationsIds = $reservations->pluck('id');

        // Récupérer les colis liés aux réservations
        $colis = Colis::whereIn('reservation_id', $reservationsIds)->get();

        // Retourner les informations complètes
        return response()->json([
            'annonce' => $annonce,
            'nombre_reservations' => $reservations->count(),
            'reservations' => $reservations,
            'colis' => $colis,
        ], 200);
    }
}
