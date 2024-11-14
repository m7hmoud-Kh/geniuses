<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fqa>
 */
class FqaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => fake()->unique()->sentence(3,false),
            'answer' => fake()->unique()->sentence(6,false),
            'module_id' => Module::inRandomOrder()->first()->id
        ];
    }
}
