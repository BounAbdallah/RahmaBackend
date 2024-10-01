<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tarif;
use App\Models\Livraison;
use App\Models\Reservation;
use App\Models\Colis;
use Illuminate\Http\Request;

class DashboardAdmin extends Controller
{
    // ... vos autres méthodes

    // Afficher toutes les informations sur le tableau de bord de l'administrateur
    public function dashboardInfo()
    {
        // Récupérer toutes les données nécessaires
        $users = User::with('roles')->get(); // Utilisateurs avec leurs rôles
        $tarifs = Tarif::all(); // Récupérer tous les tarifs
        $livraisons = Livraison::all(); // Récupérer toutes les livraisons
        $reservations = Reservation::with('annonce', 'user')->get(); // Récupérer toutes les réservations
        $colis = Colis::all(); // Récupérer tous les colis

        // Obtenir des statistiques des utilisateurs
        $totalUsers = User::count();
        $totalAdmins = User::role('admin')->count();
        $totalChauffeurs = User::role('chauffeur')->count();
        $totalClients = User::role('client')->count();

        return response()->json([
            'users' => $users,
            'tarifs' => $tarifs,
            'livraisons' => $livraisons,
            'reservations' => $reservations,
            'colis' => $colis,
            'statistics' => [
                'total_users' => $totalUsers,
                'total_admins' => $totalAdmins,
                'total_chauffeurs' => $totalChauffeurs,
                'total_clients' => $totalClients,
            ],
        ], 200);
    }
}
