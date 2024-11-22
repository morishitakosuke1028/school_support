<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Schedule;
use App\Models\GradeClass;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'grade_class_id' => GradeClass::factory(),  // Reference the factory for GradeClass
            'schedule_date' => $this->faker->date(),    // Use $this->faker instead of $faker
            'subject_id_first' => 1,                    // Provide default values for the other fields
        ];
    }
}
