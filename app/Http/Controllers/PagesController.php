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
use Illuminate\Support\Facades\DB;
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
        return view('test', ['buttons' => [
                                    'users',
                                    'user posts',
                                    'users posts count',
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
                                    'transaction1',
                                    'transaction2',
                                    'post_exists',
                                    'roles_with_user',
                                    'users_with_role'
                                ]]);
    }

    public function ajaxGetTestData(Request $request)
    {
        $item = $request->item;
        switch($request->action) {

            case('users'):
                return User::all();
                
            case('user posts'):
                try {
                    return User::findOrFail($item)->posts()->get();
                } catch (Throwable $e) { 
                    return [
                        'code' => 404,
                        'message' => 'User Not found - id=' . $item,
                        'Try with' => User::select('id')->get()->pluck('id')
                    ];
                }
                
            case('users posts count'):
                return User::select('id', 'name')->withCount('posts')->get();
                
            case('user by id'):
                try {
                    return User::findOrFail($item);
                } catch (Throwable $e) { 
                    return [
                        'code' => 404,
                        'message' => 'User Not found - id=' . $item,
                        'Try with' => User::all()->pluck('id')
                    ];
                }
 
            case('posts'):
                return Post::all();
                
            case('post by id'):
                try {
                    return Post::findOrFail($item);
                } catch (Throwable $e) { 
                    return [
                        'code' => 404,
                        'message' => 'Post Not found - id=' . $item,
                        'Try with' => Post::select('id')->get()->pluck('id')
                    ];
                }
                
            case('post by id with user'):
                return Post::with('user')->findOrFail($item);
                
            case('post by slug'):
                try {
                    return Post::where('slug', $item)->firstOrFail();
                } catch (Throwable $e) { 
                    return [
                        'code' => 404,
                        'message' => 'Post slug Not found - slug=' . $item,
                        'Try with' => Post::select('slug')->get()->pluck('slug')
                    ];
                }
                
            case('post rates'):
                return Post::findOrFail($item)->user_rate()->get()->pluck('pivot.rate')->sum();

            case('posts_categories'):
                return Post::with('user:id,name', 'categories:id,name')->orderBy('created_at', 'desc')->paginate(3);

            case('logged user'):
                return Auth::user();
                
            case('edit post multiselect'):
                return ['post' => Post::with('categories:id,name')->findOrFail($item), 'categories' => Category::all(['id', 'name'])];
                
            case('categories'):
                return Category::all();
                
            case('postsByCategory1'):
                return Post::whereHas('categories', function (Builder $query) use ($item) {
                            $query->where('category_id', '=', $item);
                        })->get();
                
            case('postsByCategory2'):
                return Category::where('id', $item)->with('post')->get();

            case('transaction1'):
                DB::beginTransaction();
                try {
                    
                    $post = Post::findOrFail($item);

                    $old_image = $post->image;
                    $post->image = 3;
                    $post->save();
                    $postD = Post::findOrFail(1);
                    DB::commit();
                    return $post;
                } catch (Throwable $e) {
                    DB::rollback();
                    return [
                        'code' => 404,
                        'message' => $e->getMessage()
                    ];
                }
    
            case('transaction2'):
                try {
                    DB::transaction(function () use ($item) {
                        $post = Post::findOrFail($item);
    
                        $old_image = $post->image;
                        $post->image = 13;
                        $post->save();
                        $postD = Post::findOrFail(1);
                    });

                } catch (Throwable $e) {
                    return [
                        'code' => 404,
                        'message' => $e->getMessage()
                    ];
                }
                break;

            case('post_exists'):
                return Category::select('id', 'name')->withExists(['post' => function ($query) use ($item) {
                            $query->where('post_id', $item);
                        }])->get();

            case('roles_with_user'):
                return Role::with('users:name,email,role_id')->get();
                
            case('users_with_role'):
                return User::with('role:id,name')->get();
                
            default:
                return [
                    'msg' => 'Bad action'
                ];
        }

    }
}
