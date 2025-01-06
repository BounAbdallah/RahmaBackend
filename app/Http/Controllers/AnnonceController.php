<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAnnonceRequest;

class AnnonceController extends Controller
{
    public function __construct()
    {
        // Constructeur si nécessaire
    }

    // Affichage de toutes les annonces
    public function index()
    {
        $annonces = Annonce::where('createur', Auth::id())->get();
        return response()->json($annonces);
    }

    // Affichage des annonces disponibles
    public function annonceDisponible()
    {
        $annonces = Annonce::where('statut', 'active')->get();
        return response()->json($annonces);
    }

    // Détail d'une annonce disponible avec les réservations et colis associés
// Détail d'une annonce disponible avec les réservations et colis associés
// Détail d'une annonce disponible avec les réservations et colis associés
public function detailAnnonceDisponible($id)
{
    // Vérifier si l'utilisateur est authentifié
    $user = Auth::user();

    // Récupérer l'annonce par ID
    $annonce = Annonce::with(['reservations.colis'])
                      ->find($id); // Utiliser find au lieu de first pour récupérer par ID

    // Vérifier si l'annonce existe
    if (!$annonce) {
        return response()->json(['message' => 'Annonce non trouvée.'], 404);
    }

    // Vérifier si l'utilisateur est le créateur ou si l'annonce est active
    if ($annonce->createur !== $user->id && $annonce->statut !== 'active') {
        return response()->json(['message' => 'Accès non autorisé.'], 403);
    }

    // Initialiser le poids total à 0
    $poidsTotal = 0;

    // Parcourir les réservations et additionner les poids des colis
    foreach ($annonce->reservations as $reservation) {
        foreach ($reservation->colis as $colis) {
            $poidsTotal += $colis->poids_kg; // Ajouter le poids de chaque colis
        }
    }

    // Inclure la somme des poids dans la réponse
    return response()->json([
        'annonce' => $annonce,
        'poids_total_colis' => $poidsTotal,
    ]);
}




    // Affichage d'une annonce spécifique
// Affichage d'une annonce spécifique
// public function show($id)
// {
//     $annonce = Annonce::with(['reservations.colis']) // Charger les relations pour les réservations et les colis
//                       ->find($id); // Utiliser find au lieu de findOrFail

//     if (!$annonce) {
//         return response()->json(['error' => 'Annonce non trouvée.'], 404); // Retourner un message d'erreur personnalisé
//     }

//     return response()->json($annonce);
// }
public function show($id)
{
    $annonce = Annonce::with([
        'reservations' => function ($query) {
            $query->select('id', 'annonce_id', 'date_reservation', 'status', 'user_id', 'colis_id');
        },
        'reservations.user' => function ($query) {
            $query->select('id', 'prenom', 'nom', 'email', 'telephone', 'adress');
        },
        'reservations.colis' => function ($query) {
            $query->select('id', 'titre', 'poids_kg', 'adresse_expediteur', 'adresse_destinataire', 'contact_destinataire', 'contact_expediteur', 'date_envoi', 'date_reception', 'statut', 'description', 'image_1', 'image_2', 'image_3');
        }
    ])
    ->select('id', 'titre', 'date_debut_reception_colis', 'date_fin_reception_colis', 'heure_fin_reception_colis', 'description', 'condition', 'statut', 'poids_kg', 'prix_par_kg', 'pays_provenance_voyage', 'region_provenance_voyage', 'pays_destination_voyage', 'region_destination_voyage')
    ->find($id);

    if (!$annonce) {
        return response()->json(['error' => 'Annonce non trouvée.'], 404);
    }

    // Calculer la somme des poids des colis liés aux réservations
    $totalReservedWeight = $annonce->reservations->sum(function ($reservation) {
        return $reservation->colis ? $reservation->colis->poids_kg : 0;
    });

    // Calculer le poids disponible
    $availableWeight = $annonce->poids_kg - $totalReservedWeight;

    // Vérifier les conditions de changement de statut
    $currentDateTime = now();
    $finReceptionDateTime = $annonce->date_fin_reception_colis . ' ' . $annonce->heure_fin_reception_colis;

    if ($availableWeight <= 0 || $currentDateTime >= $finReceptionDateTime) {
        $annonce->statut = 'expirée';
        $annonce->save();
    }

    // Ajouter le poids disponible à la réponse
    $annonce->available_weight = $availableWeight;

    return response()->json($annonce);
}





    // Création d'une nouvelle annonce
    public function store(Request $request)
    {


        // Validation des données d'entrée
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

        // Vérification de la condition sur le poids
        if ($validatedData['poids_kg'] < 1 || $validatedData['poids_kg'] > 100) {
            return response()->json(['message' => 'Le poids doit être compris entre 1 et 100 kg.'], 400);
        }

        try {
            // Ajout de l'identifiant du créateur
            $validatedData['createur'] = Auth::user()->id;

            // Création de l'annonce
            $annonce = Annonce::create($validatedData);

            return response()->json([
                "Annonce" => $annonce,
                "Createur" => $annonce->createur
            ], 201); // Code 201 pour la création réussie

        } catch (\Exception $e) {

            return response()->json(['message' => 'Annonce creation failed'], 500);
        }
    }

    // Mise à jour d'une annonce
    public function update(Request $request, $id)
    {
        $annonce = Annonce::where('createur', Auth::id())->findOrFail($id);

        $validatedData = $request->all();
        $annonce->update($validatedData);

        return response()->json($annonce);
    }

    // Méthode pour changer le statut d'une annonce
    public function changerStatut(Request $request, $id)
    {
        // Validation du nouveau statut
        $validatedData = $request->validate([
            'statut' => 'required|in:active,expirée'
        ]);

        // Recherche de l'annonce appartenant à l'utilisateur connecté
        $annonce = Annonce::where('createur', Auth::id())->findOrFail($id);

        // Mise à jour du statut de l'annonce
        $annonce->statut = $validatedData['statut'];
        $annonce->save();

        return response()->json([
            'message' => 'Statut de l\'annonce mis à jour avec succès',
            'annonce' => $annonce
        ]);
    }

    // Suppression d'une annonce
    public function destroy($id)
    {
        $annonce = Annonce::where('createur', Auth::id())->findOrFail($id);
        $annonce->delete();

        return response()->json(['message' => 'Annonce archived']);
    }

    // Suppression définitive d'une annonce
    public function forceDelete($id)
    {
        $annonce = Annonce::where('createur', Auth::id())->withTrashed()->findOrFail($id);
        $annonce->forceDelete();

        return response()->json(['message' => 'Annonce permanently deleted']);
    }

    // Historique des annonces avec filtres
    public function historique(Request $request)
    {
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
        $statut = $request->input('statut');

        $query = Annonce::where('createur', Auth::id());

        if ($dateDebut && $dateFin) {
            $query->whereBetween('created_at', [$dateDebut, $dateFin]);
        }

        if ($statut) {
            $query->where('statut', $statut);
        }

        $annonces = $query->get();

        return response()->json($annonces);
    }

    // Statistiques des annonces
    public function statistiques()
    {
        $totalAnnonces = Annonce::where('createur', Auth::id())->count();
        $totalActives = Annonce::where('createur', Auth::id())->where('statut', 'active')->count();
        $totalExpirees = Annonce::where('createur', Auth::id())->where('statut', 'expirée')->count();

        return response()->json([
            'total_annonces' => $totalAnnonces,
            'total_actives' => $totalActives,
            'total_expirees' => $totalExpirees,
        ]);
    }

    // Récupérer les colis associés à une annonce
    public function colisPourAnnonce($id)
    {
        // Récupérer l'annonce avec l'ID spécifié
        $annonce = Annonce::where('createur', Auth::id())
                          ->with(['reservations.colis']) // Charger les réservations et leurs colis
                          ->findOrFail($id);

        // Extraire tous les colis liés aux réservations de l'annonce
        $colis = [];
        foreach ($annonce->reservations as $reservation) {
            $colis = array_merge($colis, $reservation->colis->toArray());
        }

        return response()->json($colis);
    }
}
