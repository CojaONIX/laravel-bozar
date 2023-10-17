<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::factory()->count(30)->create();

        $categories = Category::all()->pluck('id');
        $users = User::all()->pluck('id');

        $posts->each(function ($post) use ($categories, $users) { 
            $post->categories()->sync($categories->random(rand(1, 2)));

            $users_rate = [];
            foreach($users->random(rand(0, count($users))) as $user) {
                $users_rate[$user] = ['rate' => rand(1,5)];
            };
            $post->user_rate()->sync($users_rate);
        });
    }
}
