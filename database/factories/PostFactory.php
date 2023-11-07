<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;

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
        $title = fake()->sentence();
        $slug = Str::slug($title, '-');

        return [
            'user_id' => User::pluck('id')->random(),
            'title' => $title,
            'body' => fake()->paragraphs(fake()->numberBetween(3, 5), true),
            'slug' => $slug,
            'image' => rand(1, 99),
            'created_at' => fake()->dateTimeBetween('-1 year', '-1 day')
        ];
    }
}
