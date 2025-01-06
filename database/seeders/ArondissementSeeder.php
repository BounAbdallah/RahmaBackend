<?php

namespace Database\Seeders;

use App\Models\Arondissement;
use Illuminate\Database\Seeder;

class ArondissementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrondissements = [
            "Almadies" => [
                "communes" => ["Mermoz-Sacré-Cœur", "Ngor", "Ouakam", "Yoff"],
                "description" => "Arrondissement côtier et résidentiel."
            ],
            "Dakar Plateau" => [
                "communes" => ["Dakar-Plateau", "Fann-Point E-Amitié", "Gueule Tapée-Fass-Colobane", "Médina"],
                "description" => "Centre administratif et commercial de Dakar."
            ],
            "Grand Dakar" => [
                "communes" => ["Biscuiterie", "Dieuppeul-Derklé", "Grand Dakar", "Hann Bel-Air", "HLM", "Sicap-Liberté"],
                "description" => "Zone urbaine dynamique avec plusieurs quartiers populaires."
            ],
            "Parcelles Assainies" => [
                "communes" => ["Cambérène", "Grand Yoff", "Parcelles Assainies", "Patte d'Oie"],
                "description" => "Quartier populaire et en pleine urbanisation."
            ],
        ];

        foreach ($arrondissements as $libelle => $data) {
            // Remplace 1 par l'ID de ton département Dakar
            $departementId = 1; // Assure-toi que l'ID correspond à celui de ton département de Dakar

            // Créer l'arrondissement
            Arondissement::create([
                'libelle' => $libelle,
                'description' => $data['description'], // Ajoute la description ici
                'commune' => json_encode($data['communes']), // Stocke les communes sous forme de JSON
                'departement_id' => $departementId,
            ]);
        }
    }
}
