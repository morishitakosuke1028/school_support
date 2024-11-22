<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\GradeClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'grade_class_id' => GradeClass::factory(), // 関連するGradeClassを自動生成
            'start_datetime' => $this->faker->dateTimeBetween('now', '+1 week'),
            'end_datetime' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'title' => $this->faker->sentence,
            'place' => $this->faker->address,
            'personal_effect' => $this->faker->word,
            'content' => $this->faker->paragraph,
        ];
    }
}
