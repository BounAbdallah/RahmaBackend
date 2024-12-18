<?php

namespace App\Http\Controllers;

use App\Mail\UserRegisteredMail;
use App\Mail\UserRegisteredNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // Méthode générique pour créer un utilisateur avec gestion d'image
    private function createUser(Request $request, array $additionalFields, string $role)
    {
        // Validation de l'image (optionnel)
        $request->validate([
            'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gestion de l'upload d'image
        $imagePath = null;
        if ($request->hasFile('photo_profil')) {
            // Sauvegarde l'image dans le répertoire "public/images"
            $imagePath = $request->file('photo_profil')->store('photo_profil', 'public');
        } else {
            // Définit l'image par défaut si aucune image n'est fournie
            $imagePath = 'https://via.placeholder.com/150';
        }

        // Déterminer le statut en fonction du rôle
        $status = ($role === 'client') ? 'actif' : 'en attente';

        // Fusionner les champs de base et les champs supplémentaires
        $userData = array_merge([
            'prenom' => $request->input('prenom'),
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'password' => Hash::make($request->input('password')),
            'nationalite' => $request->input('nationalite'),
            'adress' => $request->input('adress'),
            'commune' => $request->input('commune'),
            'photo_profil' => $imagePath, // Ajout du chemin de l'image dans les données utilisateur
            'statut' => $status, // Ajout du statut
        ], $additionalFields);

        // Création de l'utilisateur
        $user = User::create($userData);
        $user->assignRole($role);

        // Envoi de l'e-mail de confirmation à l'utilisateur
        Mail::to($user->email)->send(new UserRegisteredMail($user));

        // Envoi de l'e-mail à l'administrateur et au gestionnaire
        $admins = User::role('admin')->get(); // Récupérer tous les admins
        $gestionnaires = User::role('gestionnaire')->get(); // Récupérer tous les gestionnaires

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new UserRegisteredNotification($user));
        }

        foreach ($gestionnaires as $gestionnaire) {
            Mail::to($gestionnaire->email)->send(new UserRegisteredNotification($user));
        }

        return $user;
    }

    // Enregistrement des clients
    public function registerClient(Request $request)
    {
        $this->createUser($request, [], 'client');
        return response()->json(['message' => 'Client registered successfully'], 201);
    }

    // Enregistrement des GP
    public function registerGP(Request $request)
    {
        $additionalFields = [
            'cni' => $request->input('cni'),
            'passeport' => $request->input('passeport'),
            'date_de_naissance' => $request->input('date_de_naissance'),
        ];
        $this->createUser($request, $additionalFields, 'GP');
        return response()->json(['message' => 'GP registered successfully'], 201);
    }

    // Enregistrement des chauffeurs
    public function registerChauffeur(Request $request)
    {
        $additionalFields = [
            'cni' => $request->input('cni'),
            'permis_conduire' => $request->input('permis_conduire'),
            'date_de_naissance' => $request->input('date_de_naissance'),
        ];
        $this->createUser($request, $additionalFields, 'chauffeur');
        return response()->json(['message' => 'Chauffeur registered successfully'], 201);
    }

    // Enregistrement des livreurs
    public function registerLivreur(Request $request)
    {
        $additionalFields = [
            'cni' => $request->input('cni'),
            'permis_conduire' => $request->input('permis_conduire'),
            'date_de_naissance' => $request->input('date_de_naissance'),
        ];
        $this->createUser($request, $additionalFields, 'livreur');
        return response()->json(['message' => 'Livreur registered successfully'], 201);
    }

    // Enregistrement des admins
    public function registerAdmin(Request $request)
    {
        $this->createUser($request, [], 'admin');
        return response()->json(['message' => 'Admin registered successfully'], 201);
    }

    // Enregistrement des gestionnaires
    public function registerGestionnaire(Request $request)
    {
        $additionalFields = [
            'cni' => $request->input('cni'),
            'date_de_naissance' => $request->input('date_de_naissance'),
        ];
        $this->createUser($request, $additionalFields, 'gestionnaire');
        return response()->json(['message' => 'Gestionnaire registered successfully'], 201);
    }

    // Connexion utilisateur
    public function login(Request $request)
    {
        // Validation des données entrantes
        $validator = validator($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required|string|min:8',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
        $credentials = $request->only('email', 'password');
    
        // Vérifier si l'utilisateur existe et si son état est "archivé"
        $user = User::where('email', $credentials['email'])->first();
    
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    
        if ($user->etat === 'archivé') {
            return response()->json([
                'message' => 'Votre compte est archivé. Veuillez contacter un administrateur.'
            ], 403);
        }

        if (auth()->user()->etat !== 'actif') {
            return response()->json(['message' => 'Compte désactivé'], 403);
        }        
    
        // Tentative d'authentification
        $token = auth()->attempt($credentials);
    
        if (!$token) {
            return response()->json(['message' => 'Informations de connexion incorrectes'], 401);
        }
    
        // Retourner le jeton et les informations utilisateur
        return response()->json([
            "access_token" => $token,
            "token_type" => "bearer",
            "user" => auth()->user(),
            "role" => auth()->user()->roles[0]->name,
            "expires_in" => env("JWT_TTL") * 60 . ' seconds'
        ]);
    }
    
    public function logout(Request $request)
    {
        // Si vous utilisez Laravel Sanctum ou Passport
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Déconnexion réussie'], 200);
    }
    // Modification du compte utilisateur avec gestion d'image
    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        // Validation des données
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

        // Gestion de l'image
        if ($request->hasFile('photo_profil')) {
            // Supprimer l'ancienne image si elle existe
            if ($user->photo_profil) {
                Storage::disk('public')->delete($user->photo_profil);
            }

            // Sauvegarder la nouvelle image
            $imagePath = $request->file('photo_profil')->store('photo_profil', 'public');
            $user->update(['photo_profil' => $imagePath]);
        }

        // Mise à jour des autres informations
        $user->update($request->only('prenom', 'nom', 'email', 'telephone', 'adress', 'commune'));

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->input('password'))]);
        }

        return response()->json(['message' => 'Account updated successfully']);
    }

    // Archivage du compte utilisateur
    public function archiveAccount()
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Mettre à jour l'état de l'utilisateur
        $user->etat = 'archivé';

        // Enregistrer les modifications
        $user->save();

        return response()->json(['message' => 'Account archived successfully']);
    }

    // Restauration du compte utilisateur
    public function unarchiveAccount()
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Mettre à jour l'état de l'utilisateur
        $user->etat = 'désarchivé'; // Remarquez le changement de 'desarchivé' à 'désarchivé'

        // Enregistrer les modifications
        $user->save();

        return response()->json(['message' => 'Account unarchived successfully']);
    }

    // Suppression du compte utilisateur
    public function deleteAccount()
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Supprimer l'utilisateur
        $user->delete();

        return response()->json(['message' => 'Account deleted successfully']);
    }

    // Archiver un compte
    public function toggleEtat(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Alterne entre 'actif' et 'archivé' (désactivé)
        $user->etat = $user->etat === 'actif' ? 'archivé' : 'actif';
        $user->save();

        return response()->json([
            'message' => 'Utilisateur ' . ($user->etat === 'actif' ? 'activé' : 'désactivé') . ' avec succès',
            'user' => $user,
        ]);
    }

    // Activer un compte deja archiver
    public function desarchiverUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->etat === 'actif') {
            return response()->json(['message' => 'L\'utilisateur est déjà actif'], 400);
        }

        // Remettre l'utilisateur en 'actif'
        $user->etat = 'actif';
        $user->save();

        return response()->json([
            'message' => 'Utilisateur activé avec succès',
            'user' => $user,
        ]);
    }

}
