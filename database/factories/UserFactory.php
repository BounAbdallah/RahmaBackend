<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // return [
        //     'name' => fake()->name(),
        //     'email' => fake()->unique()->safeEmail(),
        //     'email_verified_at' => now(),
        //     'password' => static::$password ??= Hash::make('password'),
        //     'remember_token' => Str::random(10),
        // ];
        return [
            'prenom' => $this->faker->firstName(),
            'nom' => $this->faker->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'telephone' => $this->faker->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'adress' => $this->faker->address(),
            'cni' => $this->faker->numerify('######'),  // Exemple de CNI
            'permis_conduire' => $this->faker->numerify('#######'),  // Exemple de permis de conduire
            'pays_de_voyage' => $this->faker->country(),
            'region_de_voyage' => $this->faker->state(),
            'passeport' => $this->faker->numerify('#####-####'),
            'date_de_naissance' => $this->faker->date(),
            'prix_kg' => $this->faker->randomFloat(2, 1, 50),  // Prix par kg
            'commune' => $this->faker->city(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
