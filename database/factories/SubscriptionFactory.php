<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }

    public function forCategory()
    {
        return $this->state(function () {
            return [
                'category_id' => Category::inRandomOrder()->first()->id,
                'module_id' => null,
            ];
        });
    }

    public function forModule()
    {
        return $this->state(function(){
            return [
                'module_id' => Module::inRandomOrder()->first()->id,
                'category_id' => null
            ];
        });
    }
}
