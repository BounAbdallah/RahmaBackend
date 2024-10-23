
<?php

use Illuminate\Http\Request;
use App\Http\Controllers\GestionRole;
use App\Http\Controllers\GPDashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdmin;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\AnnonceGPController;
use App\Http\Controllers\Api\ColisController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\DashboardGPController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserMangementController;
use App\Http\Controllers\ZoneLivraisonController;

// Routes publiques
Route::middleware('api')->group(function () {
    Route::post('/register/admin', [AuthController::class, 'registerAdmin']);
    Route::post('/register/gestionnaire', [AuthController::class, 'registerGestionnaire']);
    Route::post('/register/client', [AuthController::class, 'registerClient'])->name('register.client');
    Route::post('/register/gp', [AuthController::class, 'registerGP'])->name('register.gp');
    Route::post('/register/chauffeur', [AuthController::class, 'registerChauffeur'])->name('register.chauffeur');
    Route::post('/register/livreur', [AuthController::class, 'registerLivreur'])->name('register.livreur');
    Route::post('/login', [AuthController::class, 'login']);
});

// Routes protégées par auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// Routes protégées par auth:api
Route::middleware('auth:api')->group(function () {
    // Gestion du compte utilisateur
    Route::patch('/account/update', [AuthController::class, 'updateAccount'])->name('account.update');
    Route::delete('/account/delete', [AuthController::class, 'deleteAccount'])->name('account.delete');
    Route::post('/user/archive', [AuthController::class, 'archiveAccount']);
    Route::post('/user/unarchive', [AuthController::class, 'unarchiveAccount']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/profil', [ProfilController::class, 'afficherProfil']); // Afficher le profil
    Route::post('/profil/modifier', [ProfilController::class, 'modifierProfil']); // Modifier le profil

});

// Routes pour la suppression complète du compte (accessible aux admins)
Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::delete('/user/delete', [AuthController::class, 'deleteAccount']);
});

// Routes pour les colis
Route::middleware('auth:api')->group(function () {
    Route::prefix('colis')->group(function () {
        Route::get('/', [ColisController::class, 'index']);
        Route::post('/', [ColisController::class, 'store']);
        Route::get('/{colis}', [ColisController::class, 'show']);
        Route::put('/{colis}', [ColisController::class, 'update']);
        Route::delete('/{colis}', [ColisController::class, 'archive']);
        Route::delete('/force-delete/{colis}', [ColisController::class, 'forceDelete']);
    });
});

// Routes pour les réservations
Route::apiResource('reservations', ReservationController::class);

Route::post('reservations', [ReservationController::class , 'store']);

// Route::post('reservations/{id}/status', [ReservationController::class, 'updateStatus']);

// Routes pour la gestion des livraisons
Route::middleware('auth:api')->group(function () {
    Route::apiResource('zones-livraison', ZoneLivraisonController::class);
});

// Routes spécifiques pour le rôle Gestionnaire
Route::middleware(['auth:api', 'role:Gestionnaire'])->group(function () {
    // Routes pour les annonces
    Route::get('/annonces', [AnnonceController::class, 'index']);
    Route::post('/annonces', [AnnonceController::class, 'store']);
    Route::get('/annonces/{id}', [AnnonceController::class, 'show']);
    Route::put('/annonces/{id}', [AnnonceController::class, 'update']);
    Route::delete('/annonces/{id}/archive', [AnnonceController::class, 'destroy']);
    Route::post('/annonces/{id}/restore', [AnnonceController::class, 'restore']);
    Route::delete('/annonces/{id}', [AnnonceController::class, 'destroy']);
});


// Routes spécifiques pour le rôle GP
Route::middleware(['auth:api', 'role:GP'])->group(function () {
    // Routes pour les annonces
    Route::get('/ListeAnnonces', [AnnonceController::class, 'index']);
    Route::post('/CreationAnnonces', [AnnonceController::class, 'store']);
    Route::get('/DetailsAnnonces/{id}', [AnnonceController::class, 'show']);
    Route::put('/ModificationAnnonces/{id}', [AnnonceController::class, 'update']);
    Route::patch('/annonces/{id}/changer-statut', [AnnonceController::class, 'changerStatut']);

    Route::delete('/ArchiverAnnonces/{id}/archive', [AnnonceController::class, 'destroy']);
    Route::post('/RestorerAnnonces/{id}/restore', [AnnonceController::class, 'restore']);
    Route::delete('/SupprimerAnnonces/{id}', [AnnonceController::class, 'destroy']);
});
// Liste des annonce des GP disponible

Route::get('/GpDisponible', [AnnonceController::class, 'annonceDisponible']);
Route::get('/detailsAnnoceGP/{id}', [AnnonceController::class, 'show']);



Route::get('/annonces/{annonceId}/colis', [ReservationController::class, 'getColisByAnnonce']);
// Routes pour les tarifs
Route::apiResource('tarifs', TarifController::class);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::post('/tarifs', [TarifController::class, 'store']);
});

// Routes pour le dashboard admin
Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    // Tableau de Bord Global
    Route::get('/dashboard', [DashboardAdmin::class, 'dashboardInfo'])->name('admin.dashboard');

    // Gestion des Utilisateurs
    Route::get('/users', [DashboardAdmin::class, 'listUsers'])->name('admin.users.list');
    Route::post('/users', [DashboardAdmin::class, 'createUser'])->name('admin.users.create');
    Route::put('/users/{id}', [DashboardAdmin::class, 'updateUser'])->name('admin.users.update');
    Route::post('/users/{id}/archive', [DashboardAdmin::class, 'archiveUser'])->name('admin.users.archive');
    Route::post('/users/{id}/unarchive', [DashboardAdmin::class, 'unarchiveUser'])->name('admin.users.unarchive');
    Route::delete('/users/{id}', [DashboardAdmin::class, 'deleteUser'])->name('admin.users.delete');

    // Gestion des Tarifs
    Route::get('/tarifs', [DashboardAdmin::class, 'listTarifs'])->name('admin.tarifs.list');
    Route::post('/tarifs', [DashboardAdmin::class, 'createTarif'])->name('admin.tarifs.create');
    Route::get('/tarifs/{tarif}', [DashboardAdmin::class, 'showTarif'])->name('admin.tarifs.show');
    Route::put('/tarifs/{tarif}', [DashboardAdmin::class, 'updateTarif'])->name('admin.tarifs.update');
    Route::delete('/tarifs/{tarif}', [DashboardAdmin::class, 'deleteTarif'])->name('admin.tarifs.delete');

    // Gestion des Annonces
    // Route::get('/annonces', [DashboardAdmin::class, 'listAnnonces'])->name('admin.annonces.list');
    // Route::post('/annonces', [DashboardAdmin::class, 'createAnnonce'])->name('admin.annonces.create');
    // Route::put('/annonces/{id}', [DashboardAdmin::class, 'updateAnnonce'])->name('admin.annonces.update');
    // Route::delete('/annonces/{id}', [DashboardAdmin::class, 'deleteAnnonce'])->name('admin.annonces.delete');

    // Gestion des Livraisons
    Route::get('/livraisons', [DashboardAdmin::class, 'listLivraisons'])->name('admin.livraisons.list');
    Route::post('/livraisons', [DashboardAdmin::class, 'createLivraison'])->name('admin.livraisons.create');
    Route::put('/livraisons/{id}', [DashboardAdmin::class, 'updateLivraison'])->name('admin.livraisons.update');
    Route::delete('/livraisons/{id}', [DashboardAdmin::class, 'deleteLivraison'])->name('admin.livraisons.delete');

    // Gestion des Réservations
    Route::get('/admin/reservations', [DashboardAdmin::class, 'listReservations'])->name('admin.reservations.list');
    Route::post('/admin/reservations', [DashboardAdmin::class, 'createReservation'])->name('admin.reservations.create');
    Route::put('/admin/reservations/{id}', [DashboardAdmin::class, 'updateReservation'])->name('admin.reservations.update');
    Route::delete('/admin/reservations/{id}', [DashboardAdmin::class, 'deleteReservation'])->name('admin.reservations.delete');
});



// Routes spécifiques pour le rôle Client
Route::middleware(['auth:api', 'role:Client'])->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'dashboard']);
    Route::put('/client/colis/{id}', [ClientController::class, 'updateColis']);
    Route::post('/client/colis/{id}/archive', [ClientController::class, 'archiveColis']);
    Route::post('/client/colis/{id}/unarchive', [ClientController::class, 'unarchiveColis']);
    Route::put('/client/reservation/{id}', [ClientController::class, 'updateReservation']);
    Route::put('/client/livraison/{id}', [ClientController::class, 'updateLivraison']);
Route::get('/historique/colis/', [ColisController::class, 'historique'])->middleware('auth');


});
Route::get('/Mesreservations', [ReservationController::class, 'userReservations'])->middleware('auth');


// Routes spécifiques pour la gestion des livraisons par les clients
Route::middleware(['auth:api', 'role:Client'])->group(function () {
    Route::apiResource('livraisons', LivraisonController::class);

});

Route::middleware(['auth:api', 'role:GP'])->group(function () {
    // Route pour afficher les annonces du GP connecté
    Route::get('/gp/mes-annonces', [DashboardGPController::class, 'mesAnnonces']);

    // Route pour afficher les réservations liées aux annonces du GP
    Route::get('/gp/mes-reservations', [DashboardGPController::class, 'mesReservations']);

    // Route pour afficher les détails des colis liés à une annonce
    Route::get('/gp/colis/annonce/{id}', [DashboardGPController::class, 'detailsColisPourAnnonce']);

    // Route pour afficher les statistiques (annonces, réservations, colis)
    Route::get('/gp/statistiques', [DashboardGPController::class, 'statistiques']);

    Route::get('/gp/annonce/{id}/colis', [DashboardGPController::class, 'colisParAnnonce'])->middleware('auth');

    Route::patch('/reservation/{id}/changer-statut', [DashboardGPController::class, 'changerStatutReservation']);

    Route::get('/annonces', [AnnonceController::class, 'index']);
    Route::post('/gp/annonces', [AnnonceController::class, 'store']);
    Route::get('/annonces/{id}', [AnnonceController::class, 'show']);
    Route::put('/annonces/{id}', [AnnonceController::class, 'update']);
    Route::delete('/annonces/{id}/archive', [AnnonceController::class, 'destroy']);
    Route::post('/annonces/{id}/restore', [AnnonceController::class, 'restore']);
    Route::delete('/annonces/{id}', [AnnonceController::class, 'destroy']);

    Route::get('/annonces/{id}/colis', [AnnonceController::class, 'colisPourAnnonce']);

Route::get('/historique', [AnnonceController::class, 'historique'])->name('annonces.historique');
Route::get('/statistiques', [AnnonceController::class, 'statistiques'])->name('annonces.statistiques');



Route::get('/reservations/{id}/total-poids', [ReservationController::class, 'totalPoidsColis']);


// Statistiques


Route::get('/statistiques/utilisateurs-actifs', [StatistiqueController::class, 'utilisateursActifs']);
Route::get('/statistiques/revenu-annonce/{id}', [StatistiqueController::class, 'revenuTotalSurAnnonce']);
Route::get('/statistiques/revenu-total', [StatistiqueController::class, 'revenuTotal']);
Route::get('/statistiques/poids-annonce/{id}', [StatistiqueController::class, 'poidsTotalSurAnnonce']);
Route::get('/statistiques/poids-total', [StatistiqueController::class, 'poidsTotal']);

});

Route::get('/notifications', [NotificationController::class, 'index']);



//Route des annonces GP


Route::middleware(['auth', 'role:GP'])->group(function () {
    Route::resource('gp-annonces', AnnonceGPController::class)->except(['show']);
    Route::post('/gp-annonces/restore/{id}', [AnnonceGPController::class, 'restore']);
    Route::get('/gp-annonces/reservations', [AnnonceGPController::class, 'reservationsUtilisateurs'])->name('gp-annonces.reservations');
    Route::get('/gp-annonces/{id}/reservations', [AnnonceGPController::class, 'reservationsAnnonce'])->name('gp-annonces.reservationsAnnonce');
    Route::get('/gp-annonces/statistiques', [AnnonceGPController::class, 'statistiques'])->name('gp-annonces.statistiques');
    Route::get('/gp-annonces/evolution-statistiques', [AnnonceGPController::class, 'evolutionStatistiques'])->name('gp-annonces.evolution-statistiques');
    Route::get('/gp-annonces/colis', [AnnonceGPController::class, 'colisLiensReservations']);
    Route::get('/gp-annonces/utilisateurs-plus-reservations', [AnnonceGPController::class, 'utilisateursPlusReserves']);
    Route::get('/gp-annonces/tous-utilisateurs-reserves', [AnnonceGPController::class, 'tousLesUtilisateursAyantReserve']);

    Route::get('/gp-annonces/{id}/colis', [AnnonceGPController::class, 'colisAnnonce']);


});
