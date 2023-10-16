<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'showHome')->name('home');
    Route::get('/test', 'showTest');
    Route::get('/old/{old_view}', 'showOldView');

    Route::get('/contact', 'showContact');
    Route::post('/contact', 'sendContactMessage');
});

Route::controller(PostsController::class)->group(function () {
    //Route::get('/post/{id}', 'getPostById');
    Route::get('/post/{slug}', 'getPostBySlug');
    Route::get('/posts/{user_id}', 'getPostsByUserId');
    Route::get('/search', 'searchPostsByTerm');
});

Route::middleware('auth')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');

        Route::get('/profiles', 'all')->name('profiles');
    });

    Route::controller(PostsController::class)->group(function () {
        Route::get('/dashboard', 'showDashboard')->name('dashboard');
        Route::get('/dashboard/posts', 'showPosts')->name('dashboard.posts');
        Route::get('/dashboard/post/new', 'showNewPost')->name('post.create.form');
        Route::post('/dashboard/post/new', 'createNewPost')->name('post.create');
        Route::get('/dashboard/post/edit/{id}', 'showEditPost')->name('post.edit.form');
        Route::put('/dashboard/post/edit/{id}', 'updateEditPost')->name('post.edit');
        Route::delete('/dashboard/post/delete/{id}', 'deletePost')->name('post.soft.delete');
        Route::patch('/dashboard/post/restore/{id}', 'restorePost')->name('post.soft.restore');

        Route::post('/ajax/post/rate', 'ajaxRate')->name('ajax.post.rate');
    });

    Route::controller(CategoriesController::class)->group(function () {
        Route::get('/dashboard/categories', 'showCategories')->name('dashboard.categories');
        Route::get('/dashboard/category/new', 'showNewCategoryForm')->name('category.create.form');
        Route::post('/dashboard/category/new', 'createNewCategory')->name('category.create');
    });
});


require __DIR__.'/auth.php';
