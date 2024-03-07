<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CategoriesController;
use Illuminate\Support\Facades\URL;

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

URL::forceScheme('https');

Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'showHome')->name('home.page');
    Route::get('/test', 'showTest')->name('test.page');
    Route::post('/test', 'ajaxGetTestData')->name('test.get.data');
    Route::get('/old/{old_view}', 'showOldView')->name('old.view.page');

    Route::get('/contact', 'showContact')->name('contact.page');
    Route::post('/contact', 'sendContactMessage')->name('contact.send');
});

Route::controller(PostsController::class)->group(function () {
    //Route::get('/post/{id}', 'getPostById');
    Route::get('/post/{slug}', 'getPostBySlug')->name('post.page');
    Route::get('/posts/{user_id}', 'getPostsByUserId');
    Route::get('/search', 'searchPostsByTerm')->name('search');
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

        Route::post('/ajax/post/rate', 'ajaxRate')->name('ajax.post.rate');
        Route::post('/ajax/post/publish', 'ajaxPublish')->name('ajax.post.publish');
    });

    Route::controller(CategoriesController::class)->group(function () {
        Route::get('/dashboard/categories', 'showCategories')->name('dashboard.categories');
        Route::get('/dashboard/category/new', 'showNewCategoryForm')->name('category.create.form');
        Route::post('/dashboard/category/new', 'createNewCategory')->name('category.create');
    });
});


require __DIR__.'/auth.php';

