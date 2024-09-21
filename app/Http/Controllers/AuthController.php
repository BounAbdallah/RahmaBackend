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

        return response()->json(['message' => 'Gestionnaire registered successfully'], 201);
    }

    // Connexion utilisateur
    public function login(Request $request)
    {
        $validator = validator($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');
        $token = auth()->attempt($credentials);

        if (!$token) {
            return response()->json(['message' => 'Information de connexion incorrectes'], 401);
        }

        return response()->json([
            "access_token" => $token,
            "token_type" => "bearer",
            "user" => auth()->user(),
            "role" => auth()->user()->roles[0]->name,
            "expires_in" => env("JWT_TTL") * 60 . 'seconds'
        ]);
    }

    // Modification du compte utilisateur
    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'prenom' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'telephone' => 'sometimes|string|max:20',
            'password' => 'sometimes|min:8|confirmed',
            'adress' => 'sometimes|string|max:255',
            'commune' => 'sometimes|string|max:255',
        ]);

        $user->update($request->only('prenom', 'nom', 'email', 'telephone', 'adress', 'commune'));

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->input('password'))]);
        }

        return response()->json(['message' => 'Account updated successfully']);
    }

    // Archivage du compte utilisateur
    public function archiveAccount()
    {
        $user = Auth::user();
        $user->archive();

        return response()->json(['message' => 'Account archived successfully']);
    }

    // Restauration du compte utilisateur
    public function unarchiveAccount()
    {
        $user = Auth::user();
        $user->unarchive();

        return response()->json(['message' => 'Account unarchived successfully']);
    }

    // Suppression complète du compte utilisateur (par un admin)
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $user->forceDelete();
            return response()->json(['message' => 'Account deleted permanently']);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Déconnexion utilisateur
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Déconnexion réussie']);
    }
}
