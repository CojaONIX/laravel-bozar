<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

// Mail
use App\Http\Requests\SendContactFormMessageRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

class PagesController extends Controller
{
    public function showOldView(Request $request, $old_view): View
    {
        return view('old.' . $old_view);
    }

    public function showHome(): View
    {
        $posts = Post::with('user:id,name', 'categories:id,name')->orderBy('created_at', 'desc')->paginate(3);
        $authors = User::select('id', 'name')->withCount('posts')->get();
        return view('home', [
            'posts' => $posts,
            'authors' => $authors,
            'selected_author' => 'All authors'
        ]);
    }

    public function showContact(): View
    {
        return view('contact');
    }

    public function sendContactMessage(SendContactFormMessageRequest $request): RedirectResponse
    {
        $name = $request->name;
        $email = $request->email;
        $message = $request->message;

        Mail::to('test@example.com')->send(new ContactForm($name, $email, $message));
        return redirect()->route('home')->withSuccess('Your message was send successfully. Thank you.');
    }

    public function showTest(Request $request): View
    {
        $userId = '9a8c4531-1c0d-4784-a650-fb5f2739522c';
        $postId = 1;
        $categoryId = 1;
        $slug = 'voluptatem-dolor-voluptatem-et-laboriosam-beatae-sequi';

        $obj = [
            'posts' => Post::with('user:id,name', 'categories:id,name')->orderBy('created_at', 'desc')->paginate(3),
            //'post rates' => Post::findOrFail($postId)->user_rate()->get()->pluck('pivot.rate')->sum(),

            //'user' => User::find($userId)->posts()->get(),
            //'user posts count' => User::select('id', 'name')->withCount('posts')->get(),

            //'roles_with_user' => Role::with('users:name,email,role_id')->get(),
            // 'user_with_roles' => User::with('role:id,name')->get(),

            // 'postsByCategory2' => Category::where('id', $categoryId)->with('post')->get(),
            // 'postsByCategory1' => Post::whereHas('categories', function (Builder $query) use ($categoryId) {
            //     $query->where('category_id', '=', $categoryId);
            // })->get(),

            // 'post_exists' => Category::select('id', 'name')->withExists(['post' => function ($query) use ($postId) {
            //     $query->where('post_id', $postId);
            // }])->get(),

            // 'edit post multiselect' => ['post' => Post::with('categories:id,name')->findOrFail(145), 'categories' => Category::all(['id', 'name'])],
            // 'posts_categories' => Post::with('user:id,name', 'categories:id,name')->orderBy('created_at', 'desc')->paginate(3),
            // 'Loged user' => Auth::user(),
            // 'all with selected cols' => Post::select('id', 'title', 'body', 'user_id')->with('user:id,email,name')->get(),
            // 'all' => Post::with('user')->get(),
            // 'select' => Post::select('id' , 'title', 'body')->findOrFail($postId)
        ];
       
        return view('test', ['object' => $obj]);
    }
}
