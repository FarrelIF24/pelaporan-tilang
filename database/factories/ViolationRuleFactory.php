<?php

namespace Database\Factories;

use App\Models\ViolationRule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ViolationRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ViolationRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => 'VR' . $this->faker->unique()->numberBetween(100, 999),
            'description' => $this->faker->sentence(10),
            'fine_amount' => $this->faker->numberBetween(50000, 1000000),
        ];
    }
}
