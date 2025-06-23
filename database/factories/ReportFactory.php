<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use App\Models\ViolationRule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $reporter = User::factory()->pelapor()->create();
        
        return [
            'reporter_id' => $reporter->id,
            'license_plate' => strtoupper($this->faker->randomLetter() . ' ' . $this->faker->numberBetween(1000, 9999) . ' ' . $this->faker->randomLetter() . $this->faker->randomLetter()),
            'photo_url' => 'violations/' . $this->faker->uuid . '.jpg',
            'violation_article_id' => ViolationRule::factory(),
            'location' => $this->faker->address,
            'violation_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['menunggu_verifikasi', 'diterima', 'ditolak']),
            'rejection_reason' => null,
            'report_fee' => null,
            'verified_by' => null,
            'created_by' => $reporter->id,
            'updated_by' => null,
        ];
    }

    /**
     * Configure the model factory to create a verified report.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function verified()
    {
        return $this->state(function (array $attributes) {
            $verifier = User::factory()->polantas()->create();
            
            return [
                'status' => 'diterima',
                'report_fee' => $this->faker->numberBetween(50000, 1000000),
                'verified_by' => $verifier->id,
                'updated_by' => $verifier->id,
            ];
        });
    }

    /**
     * Configure the model factory to create a rejected report.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function rejected()
    {
        return $this->state(function (array $attributes) {
            $verifier = User::factory()->polantas()->create();
            
            return [
                'status' => 'ditolak',
                'rejection_reason' => $this->faker->sentence(),
                'verified_by' => $verifier->id,
                'updated_by' => $verifier->id,
            ];
        });
    }
}
