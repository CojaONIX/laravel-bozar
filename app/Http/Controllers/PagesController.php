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
        $posts = Post::orderBy('created_at', 'desc')->paginate(3);
        return view('home', ['posts' => $posts]);
    }


    public function showTest(Request $request, $Model, $id): View
    {
        if($Model == 'post') {
            if($id == 'all'){
                $obj = Post::all();
            } else {
                $obj = Post::findOrFail($id);
            }
        }
        
        return view('test', ['object' => $obj]);
    }
}
