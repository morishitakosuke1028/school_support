<?php

namespace Database\Factories;

use App\Models\Homework;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomeworkFactory extends Factory
{
    protected $model = Homework::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'grade_class_id' => \App\Models\GradeClass::factory(),
            'homework_day' => $this->faker->date,
            'reading' => $this->faker->randomElement(['Read chapter 1', 'Read chapter 2']),
            'language_drill' => $this->faker->randomElement(['Complete exercise 5', 'Complete exercise 6']),
            'arithmetic' => $this->faker->randomElement(['Solve problems 1-10', 'Solve problems 11-20']),
            'diary' => $this->faker->sentence,
            'ipad' => $this->faker->boolean,
            'other' => $this->faker->sentence,
        ];
    }
}
