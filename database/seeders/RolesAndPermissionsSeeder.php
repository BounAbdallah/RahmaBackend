<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'gérer les utilisateurs',
            'attribuer des rôles',
            'créer des annonces',
            'attribuer des livraisons',
            'accepter les réservations de voiture',
            'approuver les réservations de KG',
            'gérer son profil',
            'effectuer un paiement',
            'attribuer des courses',
            'réserver des KG',
            'réserver une voiture',
            'faire une demande de livraison locale',
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->where('guard_name', 'api')->exists()) {
                Permission::create(['name' => $permission, 'guard_name' => 'api']);
            }
        }

        $roles = [
            'Admin' => [
                'gérer les utilisateurs',
                'attribuer des rôles',
                'créer des annonces',
                'attribuer des livraisons',
                'accepter les réservations de voiture',
                'approuver les réservations de KG',
                'gérer son profil',
                'effectuer un paiement',
                'attribuer des courses',
                'réserver des KG',
                'réserver une voiture',
                'faire une demande de livraison locale',
            ],
            'Gestionnaire' => [
                'gérer les utilisateurs',
                'attribuer des livraisons',
                'accepter les réservations de voiture',
                'attribuer des courses',
                'gérer son profil',
            ],
            'Chauffeur' => [
                'créer des annonces',
                'accepter les réservations de voiture',
                'gérer son profil',
            ],
            'Livreur' => [
                'attribuer des livraisons',
                'gérer son profil',
            ],
            'GP' => [
                'créer des annonces',
                'approuver les réservations de KG',
                'gérer son profil',
            ],
            'Client' => [
                'réserver des KG',
                'réserver une voiture',
                'faire une demande de livraison locale',
                'effectuer un paiement',
                'gérer son profil',
            ],
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'api']);
            foreach ($permissions as $permission) {
                $permissionInstance = Permission::where('name', $permission)->where('guard_name', 'api')->first();
                if ($permissionInstance) {
                    $role->givePermissionTo($permissionInstance);
                } else {
                    echo "La permission `$permission` n'existe pas pour le garde `api`.\n";
                }
            }
        }
    }
}
