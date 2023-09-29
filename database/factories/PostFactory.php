<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        // https://fakerphp.github.io/
        return [
            'title' => fake()->sentence(),
            'body' => fake()->paragraphs(fake()->numberBetween(3, 5), true),
            'created_at' => fake()->dateTimeBetween('-1 year', '-1 day')
        ];
    }
}
