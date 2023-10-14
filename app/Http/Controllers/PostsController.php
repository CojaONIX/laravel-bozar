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
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function showDashboard(): View
    {
        if(Auth::user()->role_id == 9) {
            $posts = Post::withoutGlobalScopes()->where('user_id', '=', Auth::id())->with(['user:id,name', 'categories'])->get();
        } else {
            $posts = Post::withoutGlobalScopes()->with(['user:id,name', 'categories'])->get();
        }
        return view('admin.dashboard', ['posts' => $posts, 'activee' => '1']);
    }

    public function showPosts(): View
    {
        if(Auth::user()->role_id == 9) {
            $posts = Post::withoutGlobalScopes()->where('user_id', '=', Auth::id())->with(['user:id,name', 'categories'])->get();
        } else {
            $posts = Post::withoutGlobalScopes()->with(['user:id,name', 'categories'])->get();
        }
        return view('admin.posts', ['posts' => $posts, 'activee' => '2']);
    }

    // public function getPostById(Request $request, $id): View
    // {
    //     $post = Post::findOrFail($id);
    //     return view('post', ['post' => $post]);
    // }

    public function getPostBySlug(Request $request, $slug): View
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('post', ['post' => $post]);
    }

    public function getPostsByUserId(Request $request, $user_id): View
    {
        $posts = Post::where('user_id', $user_id)->with('user:id,name')->orderBy('created_at', 'desc')->paginate(3);
        $authors = User::select('id', 'name')->withCount('posts')->get();
        $selected_author = User::select('name')->findOrFail($user_id);
        return view('home', ['posts' => $posts, 'authors' => $authors, 'selected_author' => $selected_author->name]);
    }

    public function showNewPost(): View
    {
        $categories = Category::all();
        return view('admin.post-new', ['categories' => $categories, 'activee' => '2']);
    }

    public function createNewPost(PostRequest $request): RedirectResponse
    {
        $post = new Post;
 
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = Auth::user()->id;
        $post->slug = Str::slug($post->title, '-');

        $image = $request->image;
        if($image) {
            $path = $image->store('public');
            $path = Str::of($path)->substr(7);
            $post->image = $path;

            $iImg = Image::make('storage/' . $path);
            $iImg->fit(300, 100)->save();
        }

        $post->save();
        $post->categories()->sync($request->categories ? $request->categories : []);
 
        return redirect()->route('dashboard.posts')->withSuccess('Post id=' . $post->id . ' added');
    }

    public function showEditPost(Request $request, $postId): View
    {
        $categories = Category::select('id', 'name')->withExists(['post' => function ($query) use ($postId) {
            $query->where('post_id', $postId);
        }])->get();
        $post = Post::select('id' , 'title', 'body')->findOrFail($postId);
        return view('admin.post-edit', ['post' => $post, 'categories' => $categories, 'activee' => '2']);
    }

    public function updateEditPost(PostRequest $request, $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
 
        $post->title = $request->title;
        $post->body = $request->body;
        $post->slug = Str::slug($post->title, '-');
        $post->save();
        $post->categories()->sync($request->categories ? $request->categories : []);

        return redirect()->route('dashboard.posts')->withSuccess('Post id=' . $id . ' edited');
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
        $authors = User::select('id', 'name')->withCount('posts')->get();
        return view('home', ['posts' => $posts, 'authors' => $authors, 'selected_author' => 'All authors', 'term' => $term]);
    }

    
    public function ajaxRate(Request $request)
    {
        
        return response()->json([
            'request' => $request->val,
            'response' => $request->val * $request->val
        ]);
    }
}
