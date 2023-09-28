<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Post;

class PostsController extends Controller
{
    public function showHomeDashboard(): View
    {
        $posts = Post::all();
        return view('dashboard', ['posts' => $posts]);
    }

    public function getPostById(Request $reqest, $id) {
        $post = Post::findOrFail($id);
        return view('post', ['post' => $post]);
    }
}
