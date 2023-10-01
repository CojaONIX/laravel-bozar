<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Post;

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
