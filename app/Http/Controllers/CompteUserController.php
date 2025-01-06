<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CompteUser;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreCompteUserRequest;
use App\Http\Requests\UpdateCompteUserRequest;

class CompteUserController extends Controller
{
   /**
     * Afficher la liste des comptes (chauffeur, livreur, GP).
     */
    public function index()
    {
        // Récupère tous les utilisateurs avec les rôles spécifiés
        $comptes = User::role(['Chauffeur', 'Livreur', 'GP'])->get();
    
        return response()->json([
            'success' => true,
            'data' => $comptes,
        ], 200);
    }

    /**
     * Créer un compte utilisateur
     */
    public function store(StoreCompteUserRequest $request)
    {
        // Validation est déjà effectuée automatiquement par StoreCompteUserRequest
        
        $validated = $request->validated();
        
        // Créer l'utilisateur avec les champs validés
        $user = User::create([
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'telephone' => $validated['telephone'],
            'adress' => $validated['adress'] ?? null,  // Peut être nul
            'cni' => $validated['cni'] ?? null,  // Peut être nul
            'permis_conduire' => $validated['permis_conduire'] ?? null,  // Peut être nul
            'passeport' => $validated['passeport'] ?? null,  // Peut être nul
            'date_de_naissance' => $validated['date_de_naissance'] ?? null,  // Peut être nul
            'commune' => $validated['commune'] ?? null,  // Peut être nul
        ]);
    
        // Assigner un rôle
        $user->assignRole($validated['role']);
    
        return response()->json([
            'success' => true,
            'message' => 'Compte créé avec succès.',
            'data' => $user,
        ], 201);
    }
    
    /**
     * Afficher les détails d'un compte.
     */
    public function show($id)
    {
        // Récupérer l'utilisateur par son ID
        $user = User::findOrFail($id); // Si l'utilisateur n'existe pas, une exception sera lancée
    
        return response()->json([
            'success' => true,
            'data' => $user->load('roles'), // Charger les rôles associés
        ], 200);
    }
    

    /**
     * Mettre à jour un compte utilisateur.
     */
    public function update(UpdateCompteUserRequest $request, $id)
    {
        // Récupérer l'utilisateur par son ID
        $user = User::findOrFail($id);
    
        // Valider et obtenir les données de la requête
        $validated = $request->validated();
    
        // Mettre à jour les informations de l'utilisateur
        $user->update([
            'prenom' => $validated['prenom'] ?? $user->prenom,
            'nom' => $validated['nom'] ?? $user->nom,
            'email' => $validated['email'] ?? $user->email,
            'telephone' => $validated['telephone'] ?? $user->telephone,
            'adress' => $validated['adress'] ?? $user->adress,
            'cni' => $validated['cni'] ?? $user->cni,
            'permis_conduire' => $validated['permis_conduire'] ?? $user->permis_conduire,
             'passeport' => $validated['passeport'] ?? $user->passeport,
            'date_de_naissance' => $validated['date_de_naissance'] ?? $user->date_de_naissance,
            'commune' => $validated['commune'] ?? $user->commune,
        ]);
    
        // Si un rôle est fourni, l'assigner
        if (isset($validated['role'])) {
            $user->syncRoles($validated['role']);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Compte mis à jour avec succès.',
            'data' => $user,
        ], 200);
    }
    

    /**
     * Supprimer un compte utilisateur (soft delete).
     */

public function destroy($id)
{
    // Récupère l'utilisateur par son ID
    $user = User::find($id);

    // Vérifie si l'utilisateur existe
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Utilisateur non trouvé.',
        ], 404);
    }

    // Supprime l'utilisateur (soft delete)
    $user->delete();

    return response()->json([
        'success' => true,
        'message' => 'Compte supprimé avec succès.',
    ], 200);
}


    /**
     * Restaurer un compte utilisateur supprimé.
     */
    public function restore($id)
    {
        // Récupère l'utilisateur supprimé
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé.',
            ], 404);
        }

        $user->restore();

        return response()->json([
            'success' => true,
            'message' => 'Compte restauré avec succès.',
            'data' => $user,
        ], 200);
    }

    /**
     * Supprimer définitivement un compte utilisateur.
     */
    public function forceDelete($id)
    {
        // Récupère l'utilisateur supprimé
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé.',
            ], 404);
        }

        $user->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Compte supprimé définitivement.',
        ], 200);
    }
}
