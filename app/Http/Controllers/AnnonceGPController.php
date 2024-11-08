<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation; // Assurez-vous d'importer le modèle Reservation

class AnnonceGPController extends Controller
{
    // Afficher la liste des annonces de l'utilisateur
    public function index()
    {
        // Récupère toutes les annonces créées par l'utilisateur connecté
        $annonces = Annonce::where('createur', Auth::id())->get();
        return response()->json($annonces);
    }

    // Stocker une nouvelle annonce
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // 'image' => 'nullable|url',
            'titre' => 'required|string|max:255',
            'date_debut_reception_colis' => 'required|date',
            'date_fin_reception_colis' => 'required|date|after_or_equal:date_debut_reception_colis',
            'description' => 'required|string',
            'condition' => 'required|string',
            'statut' => 'required|in:active,expirée',
            'poids_kg' => 'required|numeric',
            'pays_provenance_voyage' => 'nullable|string|max:255',
            'region_provenance_voyage' => 'nullable|string|max:255',
            'pays_destination_voyage' => 'nullable|string|max:255',
            'region_destination_voyage' => 'nullable|string|max:255',
            'date_prevue_voyage' => 'nullable|date',
            'heure_prevue_voyage' => 'nullable|date_format:H:i',
            'heure_debut_reception_colis' => 'nullable|date_format:H:i',
            'heure_fin_reception_colis' => 'nullable|date_format:H:i',
            'prix_par_kg' => 'required|numeric',
        ]);

        // Créer l'annonce avec l'ID de l'utilisateur connecté
        $annonce = Annonce::create(array_merge($validatedData, ['createur' => Auth::id()]));

        return response()->json(['message' => 'Annonce créée avec succès.', 'annonce' => $annonce], 201);
    }

    // Mettre à jour une annonce
    public function update(Request $request, Annonce $annonce)
    {
        // Vérifier que l'utilisateur authentifié est le créateur de l'annonce
        if ($annonce->createur !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403); // 403 Forbidden
        }

        $validatedData = $request->validate([
            'image' => 'nullable|url',
            'titre' => 'required|string|max:255',
            'date_debut_reception_colis' => 'required|date',
            'date_fin_reception_colis' => 'required|date|after_or_equal:date_debut_reception_colis',
            'description' => 'required|string',
            'condition' => 'required|string',
            'statut' => 'required|in:active,expirée',
            'poids_kg' => 'required|numeric',
            'pays_provenance_voyage' => 'nullable|string|max:255',
            'region_provenance_voyage' => 'nullable|string|max:255',
            'pays_destination_voyage' => 'nullable|string|max:255',
            'region_destination_voyage' => 'nullable|string|max:255',
            'date_prevue_voyage' => 'nullable|date',
            'heure_prevue_voyage' => 'nullable|date_format:H:i:s',
            'heure_debut_reception_colis' => 'nullable|date_format:H:i:s',
            'heure_fin_reception_colis' => 'nullable|date_format:H:i:s',
            'prix_par_kg' => 'required|numeric',
        ]);

        $annonce->update($validatedData);

        return response()->json(['message' => 'Annonce mise à jour avec succès.', 'annonce' => $annonce]);
    }

    // Archiver une annonce
    public function destroy(Annonce $annonce)
    {
        // Vérifier si l'utilisateur est le créateur de l'annonce
        if ($annonce->createur !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $annonce->delete(); // Utilise SoftDeletes pour archiver l'annonce

        return response()->json(['message' => 'Annonce archivée avec succès.']);
    }

    // Récupérer une annonce archivée
    public function restore($id)
    {
        $annonce = Annonce::withTrashed()->findOrFail($id);

        // Vérifier si l'utilisateur est le créateur de l'annonce
        if ($annonce->createur !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $annonce->restore();

        return response()->json(['message' => 'Annonce désarchivée avec succès.', 'annonce' => $annonce]);
    }

    // Afficher les réservations liées aux annonces de l'utilisateur
    public function reservationsUtilisateurs()
    {
        // Récupère toutes les réservations associées aux annonces créées par l'utilisateur
        $reservations = Reservation::whereHas('annonce', function ($query) {
            $query->where('createur', Auth::id());
        })->get();

        return response()->json($reservations);
    }

    // Afficher les réservations d'une annonce spécifique
    public function reservationsAnnonce($id)
    {
        // Trouver l'annonce
        $annonce = Annonce::findOrFail($id);

        // Vérifier si l'utilisateur est le créateur de l'annonce
        if ($annonce->createur !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403); // 403 Forbidden
        }

        // Récupérer les réservations pour l'annonce spécifique avec les colis
        $reservations = $annonce->reservations()->with('colis')->get(); // Charger les colis

        return response()->json($reservations);
    }



    // Afficher les colis liés aux réservations des annonces de l'utilisateur
public function colisLiensReservations()
{
    // Récupérer toutes les réservations associées aux annonces créées par l'utilisateur
    $reservations = Reservation::whereHas('annonce', function ($query) {
        $query->where('createur', Auth::id());
    })->with('colis') // Charger la relation colis
      ->get();

    // Récupérer les colis de chaque réservation
    $colis = $reservations->pluck('colis')->filter();

    return response()->json($colis);
}







// Afficher les colis d'une annonce spécifique
public function colisAnnonce($id)
{
    // Trouver l'annonce
    $annonce = Annonce::findOrFail($id);

    // Vérifier si l'utilisateur est le créateur de l'annonce
    if ($annonce->createur !== Auth::id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Vérifier les réservations de l'annonce
    if ($annonce->reservations->isEmpty()) {
        return response()->json(['message' => 'No reservations found'], 404);
    }

    // Récupérer les colis pour l'annonce spécifique
    $colis = $annonce->reservations->flatMap(function ($reservation) {
        return $reservation->colis; // Récupérer les colis de chaque réservation
    });

    return response()->json($colis);
}



    // Afficher les statistiques de l'utilisateur
public function statistiques()
{
    // Récupère toutes les annonces créées par l'utilisateur connecté
    $annonces = Annonce::where('createur', Auth::id())->get();

    // Compter le nombre d'annonces
    $nombreAnnonces = $annonces->count();

    // Compter le nombre de réservations
    $nombreReservations = Reservation::whereHas('annonce', function ($query) {
        $query->where('createur', Auth::id());
    })->count();

    // Compter le nombre total de colis liés aux réservations
    $nombreColis = Reservation::whereHas('annonce', function ($query) {
        $query->where('createur', Auth::id());
    })->whereNotNull('colis_id')->count(); // Compte seulement les réservations qui ont un colis associé

    return response()->json([
        'nombre_annonces' => $nombreAnnonces,
        'nombre_reservations' => $nombreReservations,
        'nombre_colis' => $nombreColis,
    ]);
}

public function utilisateursPlusReserves()
{
    // Récupérer les utilisateurs qui ont réservé les annonces de l'utilisateur connecté,
    // puis compter le nombre de réservations par utilisateur
    $utilisateursReserves = Reservation::whereHas('colis', function ($query) {
        $query->whereNotNull('user_id'); // Vérifiez si le colis est associé à un utilisateur
    })
    ->whereHas('annonce', function ($query) {
        $query->where('createur', Auth::id()); // Filtrer par l'utilisateur connecté
    })
    ->with('colis.user') // Charger les utilisateurs associés
    ->select('colis.user_id') // Sélectionner l'ID de l'utilisateur à partir de la table des colis
    ->groupBy('colis.user_id') // Grouper par l'ID de l'utilisateur
    ->orderByRaw('COUNT(*) DESC') // Compter les réservations par utilisateur
    ->get()
    ->map(function ($reservation) {
        // Récupérer l'utilisateur associé à partir de l'ID
        return $reservation->colis->user; // Assurez-vous que colis n'est pas null
    })
    ->filter(); // Supprimer les valeurs null

    return response()->json($utilisateursReserves);
}




// Afficher la liste de tous les utilisateurs qui ont réservé au moins une annonce
public function tousUtilisateursAvecReservations()
{
    // Récupérer tous les utilisateurs ayant réservé au moins une annonce
    $utilisateursAvecReservations = Reservation::whereHas('colis', function ($query) {
        $query->whereHas('user'); // S'assurer que le colis est associé à un utilisateur
    })->distinct()->with('colis.user') // Charger les utilisateurs associés
      ->get()
      ->pluck('colis.user') // Récupérer uniquement les utilisateurs
      ->unique('id'); // Supprimer les doublons

    return response()->json($utilisateursAvecReservations);
}



public function evolutionStatistiques(Request $request)
{
    // Définir la plage de dates pour les statistiques
    $dateDebut = now()->subDays(14); // 14 jours en arrière
    $dateFin = now(); // jusqu'à aujourd'hui

    // Initialiser les tableaux pour les statistiques
    $evolutionAnnonces = [];
    $evolutionReservations = [];
    $evolutionColis = [];

    // Boucle à travers les jours
    for ($date = Carbon::parse($dateDebut); $date->lessThanOrEqualTo($dateFin); $date->addDay()) {
        $jour = $date->format('Y-m-d');

        // Compter le nombre d'annonces créées ce jour
        $nombreAnnonces = Annonce::where('createur', Auth::id())
            ->whereDate('created_at', $jour)
            ->count();

        // Compter le nombre de réservations faites ce jour
        $nombreReservations = Reservation::whereHas('annonce', function ($query) use ($jour) {
            $query->where('createur', Auth::id())
                ->whereDate('created_at', $jour);
        })->count();

        // Compter le nombre total de colis liés aux réservations ce jour
        $nombreColis = Reservation::whereHas('annonce', function ($query) use ($jour) {
            $query->where('createur', Auth::id())
                ->whereDate('created_at', $jour);
        })->whereNotNull('colis_id')->count();

        // Ajouter les statistiques au tableau
        $evolutionAnnonces[$jour] = $nombreAnnonces;
        $evolutionReservations[$jour] = $nombreReservations;
        $evolutionColis[$jour] = $nombreColis;

        // Vérification des données d'aujourd'hui pour le débogage
        if ($jour === now()->format('Y-m-d')) {
           info("Données pour aujourd'hui: Annonces: $nombreAnnonces, Réservations: $nombreReservations, Colis: $nombreColis");
        }
    }

    // Récupérer les statistiques hebdomadaires
    $evolutionHebdomadaireAnnonces = [];
    $evolutionHebdomadaireReservations = [];
    $evolutionHebdomadaireColis = [];

    for ($date = Carbon::parse($dateDebut); $date->lessThanOrEqualTo($dateFin); $date->addWeek()) {
        $semaine = $date->format('Y-W');

        $nombreAnnonces = Annonce::where('createur', Auth::id())
            ->whereBetween('created_at', [$date, $date->copy()->endOfWeek()->endOfDay()])
            ->count();

        $nombreReservations = Reservation::whereHas('annonce', function ($query) use ($date) {
            $query->where('createur', Auth::id())
                ->whereBetween('created_at', [$date, $date->copy()->endOfWeek()->endOfDay()]);
        })->count();

        $nombreColis = Reservation::whereHas('annonce', function ($query) use ($date) {
            $query->where('createur', Auth::id())
                ->whereBetween('created_at', [$date, $date->copy()->endOfWeek()->endOfDay()]);
        })->whereNotNull('colis_id')->count();

        $evolutionHebdomadaireAnnonces[$semaine] = $nombreAnnonces;
        $evolutionHebdomadaireReservations[$semaine] = $nombreReservations;
        $evolutionHebdomadaireColis[$semaine] = $nombreColis;
    }

    // Récupérer les statistiques mensuelles
    $evolutionMensuelleAnnonces = [];
    $evolutionMensuelleReservations = [];
    $evolutionMensuelleColis = [];

    for ($date = Carbon::parse($dateDebut); $date->lessThanOrEqualTo($dateFin); $date->addMonth()) {
        $mois = $date->format('Y-m');

        $nombreAnnonces = Annonce::where('createur', Auth::id())
            ->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();

        $nombreReservations = Reservation::whereHas('annonce', function ($query) use ($date) {
            $query->where('createur', Auth::id())
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);
        })->count();

        $nombreColis = Reservation::whereHas('annonce', function ($query) use ($date) {
            $query->where('createur', Auth::id())
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);
        })->whereNotNull('colis_id')->count();

        $evolutionMensuelleAnnonces[$mois] = $nombreAnnonces;
        $evolutionMensuelleReservations[$mois] = $nombreReservations;
        $evolutionMensuelleColis[$mois] = $nombreColis;
    }

    // Retourner les résultats
    return response()->json([
        'evolution_annonces_journalier' => $evolutionAnnonces,
        'evolution_reservations_journalier' => $evolutionReservations,
        'evolution_colis_journalier' => $evolutionColis,
        'evolution_annonces_hebdomadaire' => $evolutionHebdomadaireAnnonces,
        'evolution_reservations_hebdomadaire' => $evolutionHebdomadaireReservations,
        'evolution_colis_hebdomadaire' => $evolutionHebdomadaireColis,
        'evolution_annonces_mensuelle' => $evolutionMensuelleAnnonces,
        'evolution_reservations_mensuelle' => $evolutionMensuelleReservations,
        'evolution_colis_mensuelle' => $evolutionMensuelleColis,
    ]);
}


}
