<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Category;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::factory()->count(30)->create();

        $categories = Category::all()->pluck('id');
        $posts->each(function ($post) use ($categories) { 
            $post->categories()->sync($categories->random(rand(1, 2)));
        });
    }
}
