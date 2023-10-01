<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\User;

class PagesController extends Controller
{
    public function showWelcome(): View
    {
        return view('welcome');
    }

    public function showHome(): View
    {
        $posts = Post::with('user:id,name')->orderBy('created_at', 'desc')->paginate(3);
        $authors = User::select('id', 'name')->get();
        return view('home', ['posts' => $posts, 'authors' => $authors, 'selected_author' => 'All authors']);
    }


    public function showTest(Request $request): View
    {
        $obj = [];
        array_push($obj, ['all with selected cols' => Post::select('id', 'title', 'body', 'user_id')->with('user:id,email,name')->get()]);
        //array_push($obj, ['all' => Post::with('user')->get()]);
        array_push($obj, ['latest' => Post::latest()->first()]);

        return view('test', ['object' => $obj]);
    }
}
