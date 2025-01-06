<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class GestionRole extends Controller
{
    // Ajouter un rôle
    public function createRole(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:roles']);
        Role::create(['name' => $request->name]);
        return response()->json(['message' => 'Rôle créé avec succès']);
    }

    // Ajouter une permission
    public function createPermission(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:permissions']);
        Permission::create(['name' => $request->name]);
        return response()->json(['message' => 'Permission créée avec succès']);
    }

    // Assigner une permission à un rôle
    public function assignPermissionToRole(Request $request)
    {
        $role = Role::findByName($request->role);
        $permission = Permission::findByName($request->permission);
        $role->givePermissionTo($permission);
        return response()->json(['message' => 'Permission assignée au rôle']);
    }

    // Lister tous les rôles et permissions
    public function listRolesPermissions()
    {
        $roles = Role::with('permissions')->get();
        return response()->json($roles);
    }

}
