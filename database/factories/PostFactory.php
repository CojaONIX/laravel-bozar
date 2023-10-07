<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::pluck('id')->random(),
            'title' => fake()->sentence(),
            'body' => fake()->paragraphs(fake()->numberBetween(3, 5), true),
            'created_at' => fake()->dateTimeBetween('-1 year', '-1 day')
        ];
    }
}
