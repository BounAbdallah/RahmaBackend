<?php

namespace Database\Seeders;

use App\Models\Colis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;

class CommandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all()->pluck('id')->toArray();
        $colis = Colis::all()->pluck('id')->toArray();

        DB::table('commande')->insert([
            [
                'titre' => 'Commande 1',
                'status' => 'en_attente',
                'type_livraison' => 'Livraison standard',
                'jour_livraison' => '2024-12-25',
                'heure_livraison' => '10:00:00',
                'adresse_destinateur' => '123 Rue des Fleurs, Paris',
                'description' => 'Description de la commande 1',
                'message' => 'Message optionnel pour la commande 1',
                'user_id' => $users[array_rand($users)],
                'colis_id' => $colis[array_rand($colis)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Commande 2',
                'status' => 'attribuer_au_livreur',
                'type_livraison' => 'Livraison express',
                'jour_livraison' => '2024-12-26',
                'heure_livraison' => '14:00:00',
                'adresse_destinateur' => '456 Rue de la Paix, Lyon',
                'description' => 'Description de la commande 2',
                'message' => null,
                'user_id' => $users[array_rand($users)],
                'colis_id' => $colis[array_rand($colis)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Commande 3',
                'status' => 'en_route',
                'type_livraison' => 'Livraison à domicile',
                'jour_livraison' => '2024-12-27',
                'heure_livraison' => '16:30:00',
                'adresse_destinateur' => '789 Avenue des Champs, Marseille',
                'description' => 'Description de la commande 3',
                'message' => 'Urgent : livrer rapidement',
                'user_id' => $users[array_rand($users)],
                'colis_id' => $colis[array_rand($colis)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}