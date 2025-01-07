<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController  extends Controller
{
    // Lister tous les utilisateurs avec leur rôle
    public function listUsers(Request $request)
    {
        $role = $request->input('role');
        $users = User::with('roles');

        if ($role) {
            $users = $users->role($role);
        }

        return response()->json($users->get());
    }   // Lister tous les utilisateurs d'un rôle spécifique
    public function listUsersByRole($role)
    {
        $users = User::role($role)->get();
        return response()->json($users);
    }

    // Liste des chauffeurs
    public function listChauffeurs()
    {
        return $this->listUsersByRole('chauffeur');
    }
    public function listClients()
    {
        return $this->listUsersByRole('client');
    }

    // Liste des livreurs
    public function listLivreurs()
    {
        return $this->listUsersByRole('livreur');
    }

    // Liste des GP
    public function listGP()
    {
        return $this->listUsersByRole('gp');
    }

    // Liste des gestionnaires
    public function listGestionnaires()
    {
        return $this->listUsersByRole('gestionnaire');
    }

    // Liste des administrateurs
    public function listAdmins()
    {
        return $this->listUsersByRole('admin');
    }


    // Afficher les détails d'un utilisateur spécifique
public function showUserDetails($id)
{
    // Récupérer l'utilisateur avec ses rôles
    $user = User::with('roles')->find($id);

    // Vérifier si l'utilisateur existe
    if (!$user) {
        return response()->json([
            'message' => 'Utilisateur non trouvé',
        ], 404);
    }

    // Retourner les détails de l'utilisateur
    return response()->json($user);
}


    // Obtenir les statistiques des utilisateurs
    public function userStatistics()
    {
        return response()->json([
            'total_users' => User::count(),
            'total_admins' => User::role('admin')->count(),
            'total_chauffeurs' => User::role('chauffeur')->count(),
            'total_client' => User::role('client')->count(),
            'total_livreurs' => User::role('livreur')->count(),
            'total_gps' => User::role('gp')->count(),
            'total_gestionnaires' => User::role('gestionnaire')->count(),
        ]);
    }

    // Ajouter un nouvel utilisateur
    public function createUser(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string|max:20',
            'role' => 'required|string|exists:roles,name',
            'password' => 'required|string|min:8',
        ]);

        // Créer un nouvel utilisateur
        $user = User::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
        ]);

        // Assigner un rôle à l'utilisateur
        $user->assignRole($request->role);

        // Retourner une réponse JSON
        return response()->json(['message' => 'Utilisateur créé avec succès']);
    }

    // Modifier un utilisateur
    public function updateUser(Request $request, $id)
    {
        // Trouver l'utilisateur par son ID
        $user = User::findOrFail($id);

        // Valider les données de la requête
        $request->validate([
            'prenom' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'telephone' => 'sometimes|string|max:20',
            'role' => 'sometimes|string|exists:roles,name',
        ]);

        // Mettre à jour les informations de l'utilisateur
        $user->update($request->only('prenom', 'nom', 'email', 'telephone'));

        // Mettre à jour le rôle de l'utilisateur si fourni
        if ($request->has('role')) {
            $user->syncRoles($request->role);
        }

        // Retourner une réponse JSON
        return response()->json(['message' => 'Utilisateur modifié avec succès']);
    }

    // Archiver un utilisateur
    public function archiveUser($id)
    {
        // Trouver l'utilisateur par son ID
        $user = User::findOrFail($id);

        // Archiver l'utilisateur en mettant à jour la colonne archived_at
        $user->archived_at = now();
        $user->save();

        // Retourner une réponse JSON
        return response()->json(['message' => 'Utilisateur archivé']);
    }

    // Désarchiver un utilisateur
    public function unarchiveUser($id)
    {
        // Trouver l'utilisateur par son ID
        $user = User::findOrFail($id);

        // Désarchiver l'utilisateur en mettant à jour la colonne archived_at
        $user->archived_at = null;
        $user->save();

        // Retourner une réponse JSON
        return response()->json(['message' => 'Utilisateur désarchivé']);
    }

    // Supprimer définitivement un utilisateur
    public function deleteUser($id)
    {
        // Trouver l'utilisateur par son ID
        $user = User::findOrFail($id);

        // Supprimer l'utilisateur de la base de données
        $user->delete();

        // Retourner une réponse JSON
        return response()->json(['message' => 'Utilisateur supprimé définitivement']);
    }
}
