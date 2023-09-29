<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Post;

class PagesController extends Controller
{
    public function showWelcome(): View
    {
        return view('welcome');
    }

    public function showHome(): View
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(3);
        return view('home', ['posts' => $posts]);
    }
}
