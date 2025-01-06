<?php

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserMangementController extends Controller
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
    }

    // Obtenir les statistiques des utilisateurs
    public function userStatistics()
    {
        $totalUsers = User::count();
        $totalAdmins = User::role('admin')->count();
        $totalChauffeurs = User::role('chauffeur')->count();
        $totalClients = User::role('client')->count();

        return response()->json([
            'total_users' => $totalUsers,
            'total_admins' => $totalAdmins,
            'total_chauffeurs' => $totalChauffeurs,
            'total_clients' => $totalClients,
        ]);
    }

    // Ajouter un nouvel utilisateur
    public function createUser(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string|max:20',
            'role' => 'required|string|exists:roles,name',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);
        return response()->json(['message' => 'Utilisateur créé avec succès']);
    }

    // Modifier un utilisateur
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'prenom' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'telephone' => 'sometimes|string|max:20',
            'role' => 'sometimes|string|exists:roles,name',
        ]);

        $user->update($request->only('prenom', 'nom', 'email', 'telephone'));

        if ($request->has('role')) {
            $user->syncRoles($request->role);
        }

        return response()->json(['message' => 'Utilisateur modifié avec succès']);
    }

    // Archiver un utilisateur
    public function archiveUser($id)
    {
        $user = User::findOrFail($id);
        $user->archived_at = now();
        $user->save();

        return response()->json(['message' => 'Utilisateur archivé']);
    }

    // Désarchiver un utilisateur
    public function unarchiveUser($id)
    {
        $user = User::findOrFail($id);
        $user->archived_at = null;
        $user->save();

        return response()->json(['message' => 'Utilisateur désarchivé']);
    }

    // Supprimer définitivement un utilisateur
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé définitivement']);
    }
}
