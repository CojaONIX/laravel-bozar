<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function showDashboard(): View
    {
        $posts = Post::with(['user:id,name', 'categories'])->get();
        $categories = Category::all();
        return view('dashboard', ['posts' => $posts, 'categories' => $categories]);
    }

    public function getPostById(Request $request, $id) {
        $post = Post::findOrFail($id);
        return view('post', ['post' => $post]);
    }


    public function getPostsByUserId(Request $request, $user_id) {
        $posts = Post::where('user_id', $user_id)->with('user:id,name')->orderBy('created_at', 'desc')->paginate(3);
        $authors = User::select('id', 'name')->get();
        $selected_author = User::select('name')->findOrFail($user_id);
        return view('home', ['posts' => $posts, 'authors' => $authors, 'selected_author' => $selected_author->name]);
    }

    public function showNewPost(): View
    {
        $categories = Category::all();
        return view('dashboard-new-post', ['categories' => $categories]);
    }

    public function createNewPost(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'categories' => 'sometimes|array'
        ]);

        $post = new Post;
 
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = Auth::user()->id;

        $post->save();
        $post->categories()->sync($request->categories ? $request->categories : []);
 
        return redirect('/dashboard');
    }

    public function showEditPost(Request $request, $id): View
    {
        $categories = Category::all(['id', 'name']);
        $post = Post::with('categories:id,name')->findOrFail($id);
        return view('dashboard-edit-post', ['post' => $post, 'categories' => $categories]);
    }

    public function updateEditPost(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'categories' => 'sometimes|array'
        ]);
        
        $post = Post::findOrFail($id);
 
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        $post->categories()->sync($request->categories ? $request->categories : []);

        return redirect()->route('dashboard')->withSuccess('Post id=' . $id . ' edited');
    }

    public function deletePost(Request $request, $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->back()->withSuccess('Post id=' . $id . ' deleted');
    }
}
