<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            //$table->timestamps();
        });

        $categories = json_decode(file_get_contents("database\categories.json"), true);
        Category::insert($categories['categories']);
        //print_r($categories['categories']);
        // foreach ($categories['categories'] as $category) {
        //     Category::create([
        //         'name' => $category['name']
        //     ]);
        // }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
