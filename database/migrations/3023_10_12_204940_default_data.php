<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Role;
use App\Models\User;
use App\Models\Category;

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
        $now = now()->toDateTimeString();
        foreach ($users as &$user) {
            $user['created_at']  = $now;
            $user['updated_at']  = $now;
            $user['password']  = Hash::make($user['password']);
        }
        User::insert($users);

        $categories = json_decode(file_get_contents('database\default_data\categories.json'), true);
        Category::insert($categories);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
