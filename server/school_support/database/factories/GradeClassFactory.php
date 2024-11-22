<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\gradeClass>
 */
class GradeClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'grade_name' => $this->faker->randomElement(['一年', '二年', '三年']),
            'class_name' => $this->faker->randomElement(['A', 'B', 'C']),
            'school_id' => 1,
        ];
    }
}
