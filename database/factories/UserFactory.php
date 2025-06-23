<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->unique()->phoneNumber(),
            'role' => $this->faker->randomElement(['Pelapor', 'Polantas']),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }


    
    /**
     * Configure the model factory to create a Pelapor user.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pelapor()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'Pelapor',
            ];
        });
    }
    
    /**
     * Configure the model factory to create a Polantas user.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function polantas()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'Polantas',
            ];
        });
    }
}
