<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZoneLivraisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zonesLivraison = [
            [
                'libelle' => 'Zone Almadies',
                'description' => 'Les Almadies, une zone huppée et très demandée pour les livraisons.',
                'arrondissement_id' => 1, // Almadies
                'arrondissement2_id' => 2, // Dakar Plateau
            ],
            [
                'libelle' => 'Zone Dakar Plateau',
                'description' => 'Dakar Plateau est le cœur de la ville, avec une forte densité de population.',
                'arrondissement_id' => 2, // Dakar Plateau
                'arrondissement2_id' => 3, // Grand Dakar
            ],
            [
                'libelle' => 'Zone Grand Dakar',
                'description' => 'Le Grand Dakar regroupe plusieurs zones populaires et est un point central de livraison.',
                'arrondissement_id' => 3, // Grand Dakar
                'arrondissement2_id' => 4, // Parcelles Assainies
            ],
            [
                'libelle' => 'Zone Parcelles Assainies',
                'description' => 'Les Parcelles Assainies, une zone très active avec beaucoup de demandes pour les livraisons.',
                'arrondissement_id' => 4, // Parcelles Assainies
                'arrondissement2_id' => 1, // Almadies
            ],
            [
                'libelle' => 'Zone Golf Sud',
                'description' => 'Golf Sud, un quartier résidentiel avec des zones commerciales.',
                'arrondissement_id' => 5, // Golf Sud
                'arrondissement2_id' => 6, // Médina Gounass
            ],
            [
                'libelle' => 'Zone Médina Gounass',
                'description' => 'Médina Gounass est une zone populaire pour la livraison de nourriture et d\'autres biens.',
                'arrondissement_id' => 6, // Médina Gounass
                'arrondissement2_id' => 7, // Ndiarème Limamoulaye
            ],
            [
                'libelle' => 'Zone Yeumbeul Nord',
                'description' => 'Yeumbeul Nord est un secteur dynamique avec une population croissante.',
                'arrondissement_id' => 8, // Yeumbeul Nord
                'arrondissement2_id' => 9, // Yeumbeul Sud
            ],
            [
                'libelle' => 'Zone Yeumbeul Sud',
                'description' => 'Yeumbeul Sud, secteur résidentiel qui bénéficie de la proximité des commerces.',
                'arrondissement_id' => 9, // Yeumbeul Sud
                'arrondissement2_id' => 10, // Malika
            ],
            [
                'libelle' => 'Zone Thiaroye',
                'description' => 'Thiaroye est un secteur en développement avec une demande croissante de services de livraison.',
                'arrondissement_id' => 11, // Dagoudane
                'arrondissement2_id' => 12, // Thiaroye
            ],
            [
                'libelle' => 'Zone Rufisque',
                'description' => 'Rufisque regroupe plusieurs zones urbaines et périphériques où les livraisons sont fréquentes.',
                'arrondissement_id' => 13, // Rufisque
                'arrondissement2_id' => 14, // Sangalkam
            ]
        ];

        // Insertion des zones de livraison
        foreach ($zonesLivraison as $zone) {
            DB::table('zone_livraisons')->insert([
                'libelle' => $zone['libelle'],
                'description' => $zone['description'],
                'arrondissement_id' => $zone['arrondissement_id'],
                'arrondissement2_id' => $zone['arrondissement2_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
