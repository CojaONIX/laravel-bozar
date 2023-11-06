<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $roles = json_decode(file_get_contents('database\default_data\roles.json'), true);
        Role::insert($roles);

        $users = json_decode(file_get_contents('database\default_data\users.json'), true);
        foreach ($users as $user) {
            User::create($user);
        }

        $categories = json_decode(file_get_contents('database\default_data\categories.json'), true);
        foreach ($categories as $cat) {
            Category::create($cat);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
