<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Routes pour l'enregistrement d'un Admin
Route::post('/register/admin', [AuthController::class, 'registerAdmin']);

// Routes pour l'enregistrement d'un Gestionnaire
Route::post('/register/gestionnaire', [AuthController::class, 'registerGestionnaire']);

// Route pour enregistrer un client
Route::post('/register/client', [AuthController::class, 'registerClient'])->name('register.client');

// Route pour enregistrer un GP
Route::post('/register/gp', [AuthController::class, 'registerGP'])->name('register.gp');

// Route pour enregistrer un chauffeur
Route::post('/register/chauffeur', [AuthController::class, 'registerChauffeur'])->name('register.chauffeur');

// Route pour enregistrer un livreur
Route::post('/register/livreur', [AuthController::class, 'registerLivreur'])->name('register.livreur');


// Route pour la connexion
Route::post('/login', [AuthController::class, 'login']);
