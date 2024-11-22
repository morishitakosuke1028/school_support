<?php

namespace Database\Factories;

use App\Models\Growth;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Growth>
 */
class GrowthFactory extends Factory
{
    protected $model = Growth::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'child_id' => \App\Models\Child::factory(),
            'height' => $this->faker->randomFloat(2, 100, 200),
            'weight' => $this->faker->randomFloat(2, 20, 100),
            'chest' => $this->faker->randomFloat(2, 50, 120),
            'abdomen' => $this->faker->randomFloat(2, 40, 100),
            'head' => $this->faker->randomFloat(2, 30, 60),
            'measurement_month' => $this->faker->date('Y-m-d'),
        ];
    }
}
