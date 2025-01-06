<?php

namespace Database\Factories;

use App\Models\Colis;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Colis>
 */
class ColisFactory extends Factory
{
    protected $model = Colis::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => $this->faker->sentence(3),
            'image_1' => $this->faker->imageUrl(640, 480, 'products', true, 'Image 1'),
            'image_2' => $this->faker->imageUrl(640, 480, 'products', true, 'Image 2'),
            'image_3' => $this->faker->imageUrl(640, 480, 'products', true, 'Image 3'),
            'poids_kg' => $this->faker->randomFloat(2, 0.1, 50), // Poids entre 0.1 kg et 50 kg
            'adresse_expediteur' => $this->faker->address(),
            'adresse_destinataire' => $this->faker->address(),
            'contact_destinataire' => $this->faker->phoneNumber(),
            'date_reception' => $this->faker->optional()->dateTimeBetween('-1 month', '+1 month'),
            'statut' => $this->faker->randomElement(['en transit', 'livré', 'en attente', 'retourné']),
            'etat' => $this->faker->randomElement(['archivé', 'desarchivé', 'en cours']),
            'description' => $this->faker->paragraph(),
            'user_id' => User::factory(), // Crée un utilisateur associé
            'reservation_id' => Reservation::factory(), // Crée une réservation associée
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
