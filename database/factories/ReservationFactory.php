<?php

namespace Database\Factories;

use App\Models\Annonce;
use App\Models\Colis;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    protected $model = Reservation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'annonce_id' => \App\Models\Annonce::factory(), // Si vous avez un modèle Annonce, créez aussi son factory
            'date_reservation' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'status' => $this->faker->randomElement(['confirmée', 'annulée', 'en attente']),
            'user_id' => User::factory(), // Crée un utilisateur fictif
            'colis_id' => Colis::factory(), // Crée un colis fictif
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
