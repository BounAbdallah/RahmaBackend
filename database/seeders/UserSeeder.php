<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = ['admin', 'gestionnaire', 'client', 'GP', 'chauffeur', 'livreur'];

        foreach ($roles as $role) {
            for ($i = 1; $i <= 3; $i++) {
                $user = User::create([
                    'prenom' => ucfirst($role) . 'Prenom' . $i,
                    'nom' => ucfirst($role) . 'Nom' . $i,
                    'email' => strtolower($role) . $i . '@example.com',
                    'telephone' => '77000000' . $i,
                    'password' => Hash::make('password'),
                    'nationalite' => 'Sénégal',
                    'adress' => 'Adresse ' . $i,
                    'commune' => 'Commune ' . $i,
                    'nationalite' => 'senegalais',
                    'photo_profil' => 'https://via.placeholder.com/150',
                    'statut' => $role === 'client' ? 'actif' : 'en attente',
                ]);

                $user->assignRole($role);
            }
        }
    }
}
