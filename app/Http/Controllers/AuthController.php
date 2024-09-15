<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\RegisterGestionnaireRequest;

class AuthController extends Controller
{
    public function registerClient(Request $request)
    {
        $user = User::create([
            'prenom' => $request->input('prenom'),
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'password' => Hash::make($request->input('password')),
            'adress' => $request->input('adress'),
            'commune' => $request->input('commune'),
        ]);

        $user->assignRole('client');  // Assigner le rôle de client

        return response()->json(['message' => 'Client registered successfully'], 201);
    }

    public function registerGP(Request $request)
    {
        $user = User::create([
            'prenom' => $request->input('prenom'),
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'password' => Hash::make($request->input('password')),
            'adress' => $request->input('adress'),
            'cni' => $request->input('cni'),
            'pays_de_voyage' => $request->input('pays_de_voyage'),
            'region_de_voyage' => $request->input('region_de_voyage'),
            'passeport' => $request->input('passeport'),
            'date_de_naissance' => $request->input('date_de_naissance'),
            'prix_kg' => $request->input('prix_kg'),
            'commune' => $request->input('commune'),
        ]);

        $user->assignRole('GP');  // Assigner le rôle de GP

        return response()->json(['message' => 'GP registered successfully'], 201);
    }

    public function registerChauffeur(Request $request)
    {
        $user = User::create([
            'prenom' => $request->input('prenom'),
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'password' => Hash::make($request->input('password')),
            'adress' => $request->input('adress'),
            'cni' => $request->input('cni'),
            'permis_conduire' => $request->input('permis_conduire'),
            'date_de_naissance' => $request->input('date_de_naissance'),
            'commune' => $request->input('commune'),
        ]);

        $user->assignRole('chauffeur');  // Assigner le rôle de chauffeur

        return response()->json(['message' => 'Chauffeur registered successfully'], 201);
    }

    public function registerLivreur(Request $request)
    {
        $user = User::create([
            'prenom' => $request->input('prenom'),
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'password' => Hash::make($request->input('password')),
            'adress' => $request->input('adress'),
            'cni' => $request->input('cni'),
            'permis_conduire' => $request->input('permis_conduire'),
            'date_de_naissance' => $request->input('date_de_naissance'),
            'commune' => $request->input('commune'),
        ]);

        $user->assignRole('livreur');  // Assigner le rôle de livreur

        return response()->json(['message' => 'Livreur registered successfully'], 201);
    }


    public function registerAdmin(Request $request)
    {
        // Créer l'utilisateur admin
        $user = User::create([
            'prenom' => $request->input('prenom'),
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Assigner le rôle admin
        $user->assignRole('admin');

        return response()->json(['message' => 'Admin registered successfully'], 201);
    }



    public function registerGestionnaire(Request $request)
    {
        // Créer l'utilisateur gestionnaire
        $user = User::create([
            'prenom' => $request->input('prenom'),
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'password' => Hash::make($request->input('password')),
            'adress' => $request->input('adress'),
            'cni' => $request->input('cni'),
            'date_de_naissance' => $request->input('date_de_naissance'),
            'commune' => $request->input('commune'),
        ]);

        // Assigner le rôle gestionnaire
        $user->assignRole('gestionnaire');

        return response()->json(['message' => 'Gestionnaire registered successfully'], 201);
    }




    public function login(Request $request)
    {
        // Valider les données d'entrée
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Déboguer les informations reçues
        \Log::info('Login attempt:', $credentials);

        // Tenter de se connecter avec les identifiants fournis
        if (!Auth::guard('api')->attempt($credentials)) {
            \Log::info('Login failed for credentials:', $credentials);
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Récupérer l'utilisateur connecté
        $user = Auth::guard('api')->user();

        // Assigner les rôles à la variable $roles
        $roles = $user->roles->pluck('name'); // Utilisation de Eloquent pour obtenir les rôles

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'roles' => $roles,
        ]);
    }



}
