<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Module>
 */
class ModuleFactory extends Factory
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
            'price' => fake()->randomFloat(2,100,800),
            'allow_in_days' => fake()->numberBetween(10,800),
            'category_id' => Category::inRandomOrder()->first()->id
        ];
    }
}
