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

use Throwable;

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

    public function showTest(Request $request)
    {
        return view('test');
    }

    public function ajaxGetTestData(Request $request)
    {
        $item = $request->item;
        switch($request->action) {

            case('users'):
                $obj = User::all();
                break;
            case('users ids'):
                $obj = User::select('id')->get();
                break;
            case('user posts'):
                $obj = User::find($item)->posts()->get();
                break;
            case('user posts count'):
                $obj = User::select('id', 'name')->withCount('posts')->get();
                break;
            case('user by id'):
                try {
                    $obj = User::findOrFail($item);
                } catch (Throwable $e) { 
                    $obj = [
                        'code' => 404,
                        'message' => 'User Not found'
                    ];
                }
                break;
 
            case('posts'):
                $obj = Post::all();
                break;
            case('post by id'):
                $obj = Post::findOrFail($item);
                break;
            case('post by id with user'):
                $obj = Post::with('user')->findOrFail($item);
                break;
            case('post by slug'):
                $obj = Post::where('slug', $item)->firstOrFail();
                break;
            case('post rates'):
                $obj = Post::findOrFail($item)->user_rate()->get()->pluck('pivot.rate')->sum();
                break;

            case('posts_categories'):
                $obj = Post::with('user:id,name', 'categories:id,name')->orderBy('created_at', 'desc')->paginate(3);
                break;

            case('logged user'):
                $obj = Auth::user();
                break;

            case('edit post multiselect'):
                $obj = ['post' => Post::with('categories:id,name')->findOrFail($item), 'categories' => Category::all(['id', 'name'])];
                break;

            case('categories'):
                $obj = Category::all();
                break;
            case('postsByCategory1'):
                $obj = Post::whereHas('categories', function (Builder $query) use ($item) {
                            $query->where('category_id', '=', $item);
                        })->get();
                break;
            case('postsByCategory2'):
                $obj = Category::where('id', $item)->with('post')->get();
                break;

            case('post_exists'):
                $obj = Category::select('id', 'name')->withExists(['post' => function ($query) use ($item) {
                            $query->where('post_id', $item);
                        }])->get();
                break;

            case('roles_with_user'):
                $obj = Role::with('users:name,email,role_id')->get();
                break;
            case('users_with_role'):
                $obj = User::with('role:id,name')->get();
                break;
            default:
                $obj = [
                    'users',
                    'users ids',
                    'user posts',
                    'user posts count',
                    'user by id',
                    'posts',
                    'post by id',
                    'post by id with user',
                    'post by slug',
                    'post rates',
                    'posts_categories',
                    'logged user',
                    'edit post multiselect',
                    'categories',
                    'postsByCategory1',
                    'postsByCategory2',
                    'post_exists',
                    'roles_with_user',
                    'users_with_role'
                ];
        }

        return $obj;

    }
}
