<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function showDashboard(): View
    {
        $posts = Post::withoutGlobalScopes()->with(['user:id,name', 'categories'])->get();
        $categories = Category::all();
        return view('dashboard', ['posts' => $posts, 'categories' => $categories]);
    }

    public function getPostById(Request $request, $id): View
    {
        $post = Post::findOrFail($id);
        return view('post', ['post' => $post]);
    }


    public function getPostsByUserId(Request $request, $user_id): View
    {
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

    public function createNewPost(PostRequest $request): RedirectResponse
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $post = new Post;
 
        $post->title = $validated->title;
        $post->body = $validated->body;
        $post->user_id = Auth::user()->id;

        $post->save();
        $post->categories()->sync($validated->categories ? $validated->categories : []);
 
        return redirect()->route('dashboard')->withSuccess('Post id=' . $post->id . ' added');
    }

    public function showEditPost(Request $request, $postId): View
    {
        $categories = Category::select('id', 'name')->withExists(['post' => function ($query) use ($postId) {
            $query->where('post_id', $postId);
        }])->get();
        $post = Post::select('id' , 'title', 'body')->findOrFail($postId);
        return view('dashboard-edit-post', ['post' => $post, 'categories' => $categories]);
    }

    public function updateEditPost(PostRequest $request, $id): RedirectResponse
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $post = Post::findOrFail($id);
 
        $post->title = $validated->title;
        $post->body = $validated->body;
        $post->save();
        $post->categories()->sync($validated->categories ? $validated->categories : []);

        return redirect()->route('dashboard')->withSuccess('Post id=' . $id . ' edited');
    }

    public function deletePost(Request $request, $id): RedirectResponse
    {
        $post = Post::withoutGlobalScopes()->findOrFail($id);
        if($post->trashed()) {
            $post->forceDelete();
            $msg = 'Post id=' . $id . ' permanently deleted';
        } else {
            $post->delete();
            $msg = 'Post id=' . $id . ' soft deleted';
        }

        return redirect()->back()->withSuccess($msg);
    }

    public function restorePost(Request $request, $id): RedirectResponse
    {
        $post = Post::withoutGlobalScopes()->findOrFail($id);
        $post->restore();

        return redirect()->back()->withSuccess('Post id=' . $id . ' restored');
    }

    public function searchPostsByTerm(Request $request): View
    {
        $request->validate([
            'term' => 'sometimes|string|max:255|nullable'
        ]);
        
        $term = $request->term;
        $posts = $term ? Post::where('title', 'like', '%' . $term . '%')->with('user:id,name')->orderBy('created_at', 'desc')->paginate(3) : Post::with('user:id,name')->orderBy('created_at', 'desc')->paginate(3);
        $authors = User::select('id', 'name')->get();
        return view('home', ['posts' => $posts, 'authors' => $authors, 'selected_author' => 'All authors', 'term' => $term]);
    }
}
