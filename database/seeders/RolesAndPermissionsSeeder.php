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
            // Permissions générales
            'gérer les utilisateurs',
            'creer une livraison',
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
            'ajouter un tarif',
            'voir la liste des utilisateurs',

            // Nouvelles permissions spécifiques aux routes d'admin
            'voir les statistiques des utilisateurs',
            'créer un utilisateur',
            'mettre à jour un utilisateur',
            'supprimer un utilisateur',
            'archiver un utilisateur',
            'désarchiver un utilisateur',
            'créer un rôle',
            'créer une permission',
            'assigner des permissions à des rôles',
            'voir les rôles et permissions',

            // Permissions spécifiques pour les clients
            'ajouter un colis',
            'modifier un colis',
            'supprimer un colis',
            'archiver un colis',
            'réserver à une annonce',


            'voir son tableau de bord',
    'modifier un colis',
    'archiver un colis',
    'désarchiver un colis',
    'modifier une réservation',
    'modifier une livraison',
            // Permissions spécifiques pour les chauffeurs
            'accepter réservations annonces',
            'refuser réservations annonces',

            // Permissions spécifiques pour les GP
            'voir les détails des colis des clients',
            'archiver les colis des clients',
        ];


        // Créer toutes les permissions si elles n'existent pas déjà
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
                'ajouter un colis',
                'ajouter un tarif',
                'modifier un colis',
                'supprimer un colis',
                'archiver un colis',
                'réserver à une annonce',
                'accepter réservations annonces',
                'refuser réservations annonces',
                'voir les détails des colis des clients',
                'archiver les colis des clients',
                'voir la liste des utilisateurs',

                // Nouvelles permissions pour l'admin
                'voir les statistiques des utilisateurs',
                'créer un utilisateur',
                'mettre à jour un utilisateur',
                'supprimer un utilisateur',
                'archiver un utilisateur',
                'désarchiver un utilisateur',
                'créer un rôle',
                'créer une permission',
                'assigner des permissions à des rôles',
                'voir les rôles et permissions',

            ],

            'Gestionnaire' => [
                'gérer les utilisateurs',
                'attribuer des livraisons',
                'accepter les réservations de voiture',
                'attribuer des courses',
                'gérer son profil',
                'ajouter un colis',
                'modifier un colis',
                'supprimer un colis',
                'archiver un colis',
                'creer une livraison',
            ],
            'Chauffeur' => [
                'créer des annonces',
                'accepter les réservations de voiture',
                'gérer son profil',
                'ajouter un colis',
                'modifier un colis',
                'archiver un colis',
                'accepter réservations annonces',
                'refuser réservations annonces',
            ],
            'Livreur' => [
                'attribuer des livraisons',
                'gérer son profil',
                'ajouter un colis',
                'modifier un colis',
                'supprimer un colis',
                'archiver un colis',
            ],
            'GP' => [
                'créer des annonces',
                'approuver les réservations de KG',
                'gérer son profil',
                'ajouter un colis',
                'modifier un colis',
                'archiver un colis',
                'voir les détails des colis des clients',
                'archiver les colis des clients',
            ],
            'Client' => [
                'réserver des KG',
                'réserver une voiture',
                'faire une demande de livraison locale',
                'effectuer un paiement',
                'gérer son profil',
                'ajouter un colis',
                'modifier un colis',
                'supprimer un colis',
                'archiver un colis',
                'réserver à une annonce',
                'creer une livraison',
                'voir son tableau de bord',
        'ajouter un colis',
        'modifier un colis',
        'supprimer un colis',
        'archiver un colis',
        'désarchiver un colis',
        'réserver à une annonce',
        'modifier une réservation',
        'modifier une livraison',
        'creer une livraison',
            ],
        ];

        // Créer les rôles et leur attribuer les permissions
        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'api']);
            foreach ($permissions as $permission) {
                $permissionInstance = Permission::where('name', $permission)->where('guard_name', 'api')->first();
                if ($permissionInstance) {
                    $role->givePermissionTo($permissionInstance);
                }
            }
        }
    }
}
