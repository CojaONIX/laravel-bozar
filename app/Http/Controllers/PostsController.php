<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Post;
use App\Models\User;

class PostsController extends Controller
{
    public function showDashboard(): View
    {
        $posts = Post::with('user:id,name')->get();
        return view('dashboard', ['posts' => $posts]);
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
        return view('dashboard-new-post');
    }

    public function createNewPost(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string'
        ]);

        $post = new Post;
 
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
 
        return redirect('/dashboard');
    }

    public function showEditPost(Request $request, $id): View
    {
        $post = Post::findOrFail($id);
        return view('dashboard-edit-post', ['post' => $post]);
    }

    public function updateEditPost(Request $request, $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
 
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return redirect()->route('dashboard')->withSuccess('Post id=' . $id . ' edited');
    }

    public function deletePost(Request $request, $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->back()->withSuccess('Post id=' . $id . ' deleted');
    }
}
