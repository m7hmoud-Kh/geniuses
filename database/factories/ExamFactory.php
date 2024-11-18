<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->sentence(3,false),
            'time_in_min' => fake()->randomNumber(2),
            'type' => fake()->randomElement(['mcq','flash','table']),
            'module_id' => Module::inRandomOrder()->first()->id,
        ];
    }
}
