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
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AnnonceGPController;
use App\Http\Controllers\Api\ColisController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\CompteUserController;
use App\Http\Controllers\DashboardGPController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\Api\NotationController;



use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ZoneLivraisonController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AnnonceManagementController;



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

// Routes protégées par auth:api
Route::middleware('auth:api')->group(function () {
    // Gestion du compte utilisateur
    Route::patch('/account/update', [AuthController::class, 'updateAccount'])->name('account.update');
    Route::delete('/account/delete', [AuthController::class, 'deleteAccount'])->name('account.delete');
    Route::post('/user/archive', [AuthController::class, 'archiveAccount']);
    Route::post('/user/unarchive', [AuthController::class, 'unarchiveAccount']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profil utilisateur
    Route::get('/profil', [ProfilController::class, 'afficherProfil']);
    Route::post('/profil/modifier', [ProfilController::class, 'modifierProfil']);

    // Routes pour les colis
    Route::prefix('colis')->group(function () {
        Route::get('/', [ColisController::class, 'index']);
        Route::post('/', [ColisController::class, 'store']);
        Route::get('/{colis}', [ColisController::class, 'show']);
        Route::put('/{colis}', [ColisController::class, 'update']);
        Route::delete('/{colis}', [ColisController::class, 'archive']);
        Route::delete('/force-delete/{colis}', [ColisController::class, 'forceDelete']);
    });

    // Routes pour les réservations
    Route::apiResource('reservations', ReservationController::class);
    Route::post('reservations/{id}/status', [ReservationController::class, 'updateStatus']);
    Route::get('/Mesreservations', [ReservationController::class, 'userReservations']);

    // Routes pour la gestion des livraisons
    Route::apiResource('zones-livraison', ZoneLivraisonController::class);

    // Routes pour les notifications
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);
    Route::post('notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
});

// Routes spécifiques pour le rôle Admin
Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    // Gestion des utilisateurs
    Route::put('/users/{id}/toggle-etat', [AuthController::class, 'toggleEtat']);
    Route::put('/users/{id}/activer', [AuthController::class, 'desarchiverUser']);
    Route::delete('/user/delete', [AuthController::class, 'deleteAccount']);
    Route::prefix('comptes')->group(function () {
        Route::get('', [CompteUserController::class, 'index']);
        Route::post('', [CompteUserController::class, 'store']);
        Route::get('{compteUser}', [CompteUserController::class, 'show']);
        Route::put('{compteUser}', [CompteUserController::class, 'update']);
        Route::delete('{compteUser}', [CompteUserController::class, 'destroy']);
        Route::post('{id}/restore', [CompteUserController::class, 'restore']);
        Route::delete('{id}/force-delete', [CompteUserController::class, 'forceDelete']);
    });

    // Gestion des tarifs
    Route::apiResource('tarifs', TarifController::class);

    // Gestion du dashboard admin
    Route::get('/dashboard', [DashboardAdmin::class, 'dashboardInfo'])->name('admin.dashboard');
    Route::get('/users', [DashboardAdmin::class, 'listUsers'])->name('admin.users.list');
    Route::post('/users', [DashboardAdmin::class, 'createUser'])->name('admin.users.create');
    Route::put('/users/{id}', [DashboardAdmin::class, 'updateUser'])->name('admin.users.update');
    Route::post('/users/{id}/archive', [DashboardAdmin::class, 'archiveUser'])->name('admin.users.archive');
    Route::post('/users/{id}/unarchive', [DashboardAdmin::class, 'unarchiveUser'])->name('admin.users.unarchive');
    Route::delete('/users/{id}', [DashboardAdmin::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/tarifs', [DashboardAdmin::class, 'listTarifs'])->name('admin.tarifs.list');
    Route::post('/tarifs', [DashboardAdmin::class, 'createTarif'])->name('admin.tarifs.create');
    Route::get('/tarifs/{tarif}', [DashboardAdmin::class, 'showTarif'])->name('admin.tarifs.show');
    Route::put('/tarifs/{tarif}', [DashboardAdmin::class, 'updateTarif'])->name('admin.tarifs.update');
    Route::delete('/tarifs/{tarif}', [DashboardAdmin::class, 'deleteTarif'])->name('admin.tarifs.delete');
    Route::get('/livraisons', [DashboardAdmin::class, 'listLivraisons'])->name('admin.livraisons.list');
    Route::post('/livraisons', [DashboardAdmin::class, 'createLivraison'])->name('admin.livraisons.create');
    Route::put('/livraisons/{id}', [DashboardAdmin::class, 'updateLivraison'])->name('admin.livraisons.update');
    Route::delete('/livraisons/{id}', [DashboardAdmin::class, 'deleteLivraison'])->name('admin.livraisons.delete');
    Route::get('/admin/reservations', [DashboardAdmin::class, 'listReservations'])->name('admin.reservations.list');
    Route::post('/admin/reservations', [DashboardAdmin::class, 'createReservation'])->name('admin.reservations.create');
    Route::put('/admin/reservations/{id}', [DashboardAdmin::class, 'updateReservation'])->name('admin.reservations.update');
    Route::delete('/admin/reservations/{id}', [DashboardAdmin::class, 'deleteReservation'])->name('admin.reservations.delete');
});

// Routes spécifiques pour le rôle Gestionnaire
Route::middleware(['auth:api', 'role:Gestionnaire'])->group(function () {
    // Routes pour les annonces
    Route::get('/annonces', [AnnonceController::class, 'indexGestionnaire']);
    Route::post('/annonces', [AnnonceController::class, 'store']);
    Route::get('/annonces/{id}', [AnnonceController::class, 'show']);
    Route::put('/annonces/{id}', [AnnonceController::class, 'update']);
    Route::delete('/annonces/{id}/archive', [AnnonceController::class, 'destroy']);
    Route::post('/annonces/{id}/restore', [AnnonceController::class, 'restore']);
    Route::delete('/annonces/{id}', [AnnonceController::class, 'destroy']);

    // routes pour la gestion des utilisateurs pour le gestionnaire
Route::get('/stat-users', [UserManagementController::class, 'userStatistics']);
Route::get('/listes-livreurs', [UserManagementController::class, 'listLivreurs']);
Route::get('/listes-chauffeurs', [UserManagementController::class, 'listChauffeurs']);
Route::get('/listes-GP', [UserManagementController::class, 'listGP']);
Route::get('/listes-gestionnaires', [UserManagementController::class, 'listGestionnaires']);
Route::get('/listes-clients', [UserManagementController::class, 'listClients']);

// details d'un utilisateur

Route::get('/details/{id}', [UserManagementController::class, 'showUserDetails']);




//Routes pour la gestion des annonces pour le gestionnaire


Route::get('/liste-annonces', [AnnonceManagementController::class, 'listeAnnonce']);

// details d'une annonce

Route::get('/details-annonce/{id}', [AnnonceManagementController::class, 'showAnnonceDetails']);



// Routes pour la gestion des livraisons


Route::apiResource('livraisons', LivraisonController::class);



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
    Route::get('/GpDisponible', [AnnonceController::class, 'annonceDisponible']);
    Route::get('/detailsAnnoceGP/{id}', [AnnonceController::class, 'show']);
    Route::get('/gp/mes-annonces', [DashboardGPController::class, 'mesAnnonces']);
    Route::get('/gp/mes-reservations', [DashboardGPController::class, 'mesReservations']);
    Route::get('/gp/colis/annonce/{id}', [DashboardGPController::class, 'detailsColisPourAnnonce']);
    Route::get('/gp/statistiques', [DashboardGPController::class, 'statistiques']);
    Route::get('/gp/annonce/{id}/colis', [DashboardGPController::class, 'colisParAnnonce']);
    Route::patch('/reservation/{id}/changer-statut', [DashboardGPController::class, 'changerStatutReservation']);
    Route::patch('/colis/{id}/statut', [ColisController::class, 'changerStatutColis']);
    Route::get('/annonces/{id}/colis', [AnnonceController::class, 'colisPourAnnonce']);
    Route::get('/historique', [AnnonceController::class, 'historique'])->name('annonces.historique');
    Route::get('/statistiques', [AnnonceController::class, 'statistiques'])->name('annonces.statistiques');
    Route::get('/reservations/{id}/total-poids', [ReservationController::class, 'totalPoidsColis']);
    Route::get('/statistiques/utilisateurs-actifs', [StatistiqueController::class, 'utilisateursActifs']);
    Route::get('/statistiques/revenu-annonce/{id}', [StatistiqueController::class, 'revenuTotalSurAnnonce']);
    Route::get('/statistiques/revenu-total', [StatistiqueController::class, 'revenuTotal']);
    Route::get('/statistiques/poids-annonce/{id}', [StatistiqueController::class, 'poidsTotalSurAnnonce']);
    Route::get('/statistiques/poids-total', [StatistiqueController::class, 'poidsTotal']);
    Route::get('/annonces/nombre-reservations', [ReservationController::class, 'statistiques']);
    Route::get('/statistiques/reservations', [ReservationController::class, 'nombreReservationsParUtilisateur']);
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

// Routes spécifiques pour le rôle Client
Route::middleware(['auth:api', 'role:Client'])->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'dashboard']);
    Route::put('/client/colis/{id}', [ClientController::class, 'updateColis']);
    Route::post('/client/colis/{id}/archive', [ClientController::class, 'archiveColis']);
    Route::post('/client/colis/{id}/unarchive', [ClientController::class, 'unarchiveColis']);
    Route::put('/client/reservation/{id}', [ClientController::class, 'updateReservation']);
    Route::put('/client/livraison/{id}', [ClientController::class, 'updateLivraison']);
    Route::get('/historique/colis/', [ColisController::class, 'historique']);
});

// Routes pour les commandes
Route::get('/commandes', [CommandeController::class, 'index']);
Route::get('/commandes/{id}', [CommandeController::class, 'show']);
Route::post('/commandes', [CommandeController::class, 'store']);
Route::put('/commandes/{id}', [CommandeController::class, 'update']); 


// Routes pour les notations
Route::apiResource('notations', NotationController::class);
Route::get('/annonces/{annonceId}/colis', [ReservationController::class, 'getColisByAnnonce']);


