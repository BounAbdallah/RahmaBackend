<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\Api\ColisController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ZoneLivraisonController;

// Routes publiques
Route::middleware('api')->group(function () {
    Route::post('/register/admin', [AuthController::class, 'registerAdmin']);
Route::post('/register/gestionnaire', [AuthController::class, 'registerGestionnaire']);
});

// Routes publiques
Route::post('/register/client', [AuthController::class, 'registerClient'])->name('register.client');
Route::post('/register/gp', [AuthController::class, 'registerGP'])->name('register.gp');
Route::post('/register/chauffeur', [AuthController::class, 'registerChauffeur'])->name('register.chauffeur');
Route::post('/register/livreur', [AuthController::class, 'registerLivreur'])->name('register.livreur');
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées par auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});

// Routes protégées par auth:api
Route::middleware('auth:api')->group(function () {
    // Gestion du compte utilisateur
    Route::put('/account/update', [AuthController::class, 'updateAccount'])->name('account.update');
    Route::delete('/account/delete', [AuthController::class, 'deleteAccount'])->name('account.delete');
    Route::post('/user/archive', [AuthController::class, 'archiveAccount']);
    Route::post('/user/unarchive', [AuthController::class, 'unarchiveAccount']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Routes pour la suppression complète du compte (accessible aux admins)
Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::delete('/user/delete', [AuthController::class, 'deleteAccount']);
});

// Routes pour les colis
Route::middleware(['auth:api'])->group(function () {
    Route::prefix('colis')->group(function () {
        Route::get('/', [ColisController::class, 'index']);
        Route::post('/', [ColisController::class, 'store']);
        Route::get('/{colis}', [ColisController::class, 'show']);
        Route::put('/{colis}', [ColisController::class, 'update']);
        Route::delete('/{colis}', [ColisController::class, 'destroy']);
        Route::delete('/force-delete/{colis}', [ColisController::class, 'forceDelete']);
    });
});

// Routes pour les réservations
Route::apiResource('reservations', ReservationController::class);
Route::post('reservations/{id}/status', [ReservationController::class, 'updateStatus']);

// Routes pour la gestion des livraisons

// Routes pour les zones de livraison
Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('zones-livraison', ZoneLivraisonController::class);
});

Route::middleware(['auth:api', 'role:Client'])->group(function () {
    Route::apiResource('livraisons', LivraisonController::class);

});

// Routes protégées par auth:api et rôle gestionnaire
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


Route::apiResource('tarifs', TarifController::class);


Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::post('/tarifs', [TarifController::class, 'store']);
});
