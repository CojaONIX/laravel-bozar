<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function showWelcome(): View
    {
        return view('welcome');
    }

    public function showHome(): View
    {
        $posts = Post::with('user:id,name', 'categories:id,name')->orderBy('created_at', 'desc')->paginate(3);
        $authors = User::select('id', 'name')->get();
        return view('home', ['posts' => $posts, 'authors' => $authors, 'selected_author' => 'All authors']);
    }


    public function showTest(Request $request): View
    {
        $obj = [
            'edit post multiselect' => ['post' => Post::with('categories:id,name')->findOrFail(145), 'categories' => Category::all(['id', 'name'])],
            // 'posts_categories' => Post::with('user:id,name', 'categories:id,name')->orderBy('created_at', 'desc')->paginate(3),
            // 'Loged user' => Auth::user(),
            // 'all with selected cols' => Post::select('id', 'title', 'body', 'user_id')->with('user:id,email,name')->get(),
            // 'all' => Post::with('user')->get(),
            // 'latest' => Post::latest()->first()
        ];
       
        return view('test', ['object' => $obj]);
    }
}
