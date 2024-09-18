<?php

namespace App\Http\Controllers;

use App\Mail\UserRegisteredMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class AuthController extends Controller
{
    // Méthode générique pour créer un utilisateur
    private function createUser(Request $request, array $additionalFields, string $role)
    {
        $userData = array_merge([
            'prenom' => $request->input('prenom'),
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'password' => Hash::make($request->input('password')),
            'adress' => $request->input('adress'),
            'commune' => $request->input('commune'),
        ], $additionalFields);

        $user = User::create($userData);
        $user->assignRole($role);

        // Envoi de l'e-mail de confirmation
        Mail::to($user->email)->send(new UserRegisteredMail($user));

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
            'pays_de_voyage' => $request->input('pays_de_voyage'),
            'region_de_voyage' => $request->input('region_de_voyage'),
            'passeport' => $request->input('passeport'),
            'date_de_naissance' => $request->input('date_de_naissance'),
            'prix_kg' => $request->input('prix_kg'),
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

        // Envoyer un email de vérification
        // $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Gestionnaire registered successfully'], 201);
    }

    // Login des utilisateurs
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::guard('api')->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::guard('api')->user();

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Your email address is not verified. Please check your email for the verification link.',
            ], 403);
        }

        // Générer le token API
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $roles = $user->roles->pluck('name');

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'roles' => $roles,
            'token' => $token,
        ]);
    }

    // Modification du compte utilisateur
    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        // Validation des champs
        $request->validate([
            'prenom' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'telephone' => 'sometimes|string|max:20',
            'password' => 'sometimes|min:8|confirmed',
            'adress' => 'sometimes|string|max:255',
            'commune' => 'sometimes|string|max:255',
        ]);

        // Mise à jour des informations de l'utilisateur
        $user->update($request->only('prenom', 'nom', 'email', 'telephone', 'adress', 'commune'));

        // Mise à jour du mot de passe si fourni
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->input('password'))]);
        }

        return response()->json(['message' => 'Account updated successfully']);
    }

    // Suppression du compte utilisateur (archivage)
    public function archiveAccount()
    {
        $user = Auth::user();

        // Archiver le compte de l'utilisateur
        $user->archive();

        return response()->json(['message' => 'Account archived successfully']);
    }

    // Restauration du compte utilisateur (dé-archivage)
    public function unarchiveAccount()
    {
        $user = Auth::user();

        // Restaurer le compte de l'utilisateur
        $user->unarchive();

        return response()->json(['message' => 'Account unarchived successfully']);
    }

    // Suppression complète du compte utilisateur (accessible uniquement aux admins)
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur est un admin
        if ($user->hasRole('admin')) {
            // Suppression complète du compte utilisateur
            $user->forceDelete();
            return response()->json(['message' => 'Account deleted permanently']);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Déconnexion des utilisateurs
    public function logout(Request $request)
    {
        // Récupère l'utilisateur authentifié
        $user = Auth::guard('api')->user();

        if ($user) {
            // Révoque tous les tokens de l'utilisateur (déconnexion complète)
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Deconnexion reussi avec succès !😉'
            ], 200);
        }

        return response()->json([
            'message' => "Aucun utilisateur n'est connecté ❌!"
        ], 401);
    }
}
