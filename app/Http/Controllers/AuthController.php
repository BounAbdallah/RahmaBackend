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

        $user->assignRole('client');

        // Envoyer un e-mail de confirmation après la création du compte
        Mail::to($user->email)->send(new UserRegisteredMail($user));

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

        $user->assignRole('GP');

        // Envoyer un e-mail de confirmation après la création du compte
        Mail::to($user->email)->send(new UserRegisteredMail($user));

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

        $user->assignRole('chauffeur');

        // Envoyer un e-mail de confirmation après la création du compte
        Mail::to($user->email)->send(new UserRegisteredMail($user));

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

        $user->assignRole('livreur');

        // Envoyer un e-mail de confirmation après la création du compte
        Mail::to($user->email)->send(new UserRegisteredMail($user));

        return response()->json(['message' => 'Livreur registered successfully'], 201);
    }

    public function registerAdmin(Request $request)
    {
        $user = User::create([
            'prenom' => $request->input('prenom'),
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->assignRole('admin');

        // Envoyer un e-mail de confirmation après la création du compte
        Mail::to($user->email)->send(new UserRegisteredMail($user));

        return response()->json(['message' => 'Admin registered successfully'], 201);
    }

    public function registerGestionnaire(Request $request)
    {
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

        $user->assignRole('gestionnaire');
        $user->sendEmailVerificationNotification();

        // Envoyer un e-mail de confirmation après la création du compte
        Mail::to($user->email)->send(new UserRegisteredMail($user));

        return response()->json(['message' => 'Gestionnaire registered successfully'], 201);
    }




    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        \Log::info('Login attempt:', $credentials);

        if (!Auth::guard('api')->attempt($credentials)) {
            \Log::info('Login failed for credentials:', $credentials);
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::guard('api')->user();

        // Vérification si l'email est confirmé
        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Your email address is not verified. Please check your email for the verification link.',
            ], 403);
        }

        // Génération du token API
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        $roles = $user->roles->pluck('name');

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'roles' => $roles,
            'token' => $token, // Ajoute le token à la réponse
        ]);
    }
}
