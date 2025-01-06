<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfilController extends Controller
{
    // Afficher le profil de l'utilisateur connecté
    public function afficherProfil()
    {
        $user = Auth::user(); // Récupérer l'utilisateur connecté
        return response()->json($user); // Retourner les informations de l'utilisateur sous forme de JSON
    }

    // Modifier les informations du profil
    public function modifierProfil(Request $request)
    {
        $user = Auth::user(); // Récupérer l'utilisateur connecté

        // Validation des données d'entrée
        $request->validate([
            'prenom' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'telephone' => 'sometimes|string|max:20',
            'password' => 'sometimes|min:8|confirmed',
            'adress' => 'sometimes|string|max:255',
            'commune' => 'sometimes|string|max:255',
            'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gestion de l'image de profil
        if ($request->hasFile('photo_profil')) {
            // Supprimer l'ancienne image si elle existe
            if ($user->photo_profil && Storage::disk('public')->exists($user->photo_profil)) {
                Storage::disk('public')->delete($user->photo_profil);
            }

            // Sauvegarder la nouvelle image
            $imagePath = $request->file('photo_profil')->store('photo_profil', 'public');
            $user->photo_profil = $imagePath;
        }

        // Mise à jour des autres informations
        $user->prenom = $request->input('prenom', $user->prenom);
        $user->nom = $request->input('nom', $user->nom);
        $user->email = $request->input('email', $user->email);
        $user->telephone = $request->input('telephone', $user->telephone);
        $user->adress = $request->input('adress', $user->adress);
        $user->commune = $request->input('commune', $user->commune);

        // Mise à jour du mot de passe si fourni
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Sauvegarder les modifications
        $user->save();

        return response()->json(['message' => 'Profil mis à jour avec succès']);
    }
}
