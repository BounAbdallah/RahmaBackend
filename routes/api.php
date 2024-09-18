<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnnonceController;

// Routes publiques
Route::post('/register/admin', [AuthController::class, 'registerAdmin']);
Route::post('/register/gestionnaire', [AuthController::class, 'registerGestionnaire']);
Route::post('/register/client', [AuthController::class, 'registerClient'])->name('register.client');
Route::post('/register/gp', [AuthController::class, 'registerGP'])->name('register.gp');
Route::post('/register/chauffeur', [AuthController::class, 'registerChauffeur'])->name('register.chauffeur');
Route::post('/register/livreur', [AuthController::class, 'registerLivreur'])->name('register.livreur');
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Routes pour les annonces
    Route::get('/annonces', [AnnonceController::class, 'index']);
    Route::post('/annonces', [AnnonceController::class, 'store']);
    Route::get('/annonces/{id}', [AnnonceController::class, 'show']);
    Route::put('/annonces/{id}', [AnnonceController::class, 'update']);
    Route::delete('/annonces/{id}/archive', [AnnonceController::class, 'archive']);
    Route::post('/annonces/{id}/restore', [AnnonceController::class, 'restore']);
    Route::delete('/annonces/{id}', [AnnonceController::class, 'destroy']);
});


// Route pour la deconnexion :





Route::middleware('auth:sanctum')->group(function () {
    // Route pour la modification du compte utilisateur
    Route::put('/account/update', [AuthController::class, 'updateAccount'])->name('account.update');

    // Route pour la suppression du compte utilisateur
    Route::delete('/account/delete', [AuthController::class, 'deleteAccount'])->name('account.delete');

    // Route pour la déconnexion
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::middleware('auth:api')->group(function () {
    Route::post('/user/archive', [AuthController::class, 'archiveAccount']);
    Route::post('/user/unarchive', [AuthController::class, 'unarchiveAccount']);
});

// Route pour la suppression complète du compte (accessible uniquement aux admins)
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::delete('/user/delete', [AuthController::class, 'deleteAccount']);
});
