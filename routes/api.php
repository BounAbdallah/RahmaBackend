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
