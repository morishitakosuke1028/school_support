<?php

namespace Database\Factories;

use App\Models\Child;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Child>
 */
class ChildFactory extends Factory
{
    protected $model = Child::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'kana' => 'てすと',
            'email' => $this->faker->unique()->safeEmail,
            'zip' => $this->faker->postcode,
            'address' => $this->faker->address,
            'tel' => $this->faker->phoneNumber,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'admission_date' => $this->faker->date,
            'movein_date' => $this->faker->date,
            'graduation_date' => $this->faker->optional()->date,
            'birthday' => $this->faker->date,
            'pin_code' => Str::random(6),
            'session_id' => Str::random(10),
            'school_id' => 1,
            'password' => bcrypt('password'),
        ];
    }
}
