<?php

namespace App\Http\Controllers;

use App\Models\Annonce; // Assurez-vous que votre modèle Annonce est correctement importé
use App\Models\User; // Assurez-vous que votre modèle User est correctement importé
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class StatistiqueController extends Controller
{
    // Méthode pour obtenir les utilisateurs les plus actifs
    public function utilisateursActifs()
    {
        $utilisateursActifs = User::withCount('annonces')
            ->orderBy('annonces_count', 'desc')
            ->take(10)
            ->get();

        return response()->json($utilisateursActifs);
    }

    // Méthode pour obtenir le revenu total sur une annonce
    public function revenuTotalSurAnnonce($id)
    {
        $annonce = Annonce::findOrFail($id);
        $revenuTotal = $annonce->prix_par_kg * $annonce->poids_kg; // Calculez le revenu total

        return response()->json([
            'annonce_id' => $id,
            'revenu_total' => $revenuTotal
        ]);
    }

    // Méthode pour obtenir le revenu total sur toutes les annonces
    public function revenuTotal()
    {
        $revenuTotal = Annonce::all()->sum(function ($annonce) {
            return $annonce->prix_par_kg * $annonce->poids_kg; // Calculez le revenu total pour chaque annonce
        });

        return response()->json([
            'revenu_total' => $revenuTotal
        ]);
    }

    // Méthode pour obtenir le poids total sur une annonce
    public function poidsTotalSurAnnonce($id)
    {
        $annonce = Annonce::findOrFail($id);
        $poidsTotal = $annonce->poids_kg; // Le poids total de l'annonce

        return response()->json([
            'annonce_id' => $id,
            'poids_total' => $poidsTotal
        ]);
    }

    // Méthode pour obtenir le poids total sur toutes les annonces
    public function poidsTotal()
    {
        // Récupérer l'utilisateur authentifié
        $userId = Auth::id();

        // Calculer le poids total des annonces créées par cet utilisateur
        $poidsTotal = Annonce::where('createur', $userId)->sum('poids_kg'); // Calculez le poids total

        return response()->json([
            'poids_total' => $poidsTotal
        ]);
    }
}
