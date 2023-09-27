<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    public function getPostById(Request $reqest, $id) {
        $post = Post::findOrFail($id);
        return view('post', ['post' => $post]);
    }
}
