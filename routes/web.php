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
    Route::get('/posts/{user_id}', 'getPostsByUserId')->name('posts.by.user');
    Route::get('/search', 'searchPostsByTerm')->name('search');
});

Route::middleware('auth')->prefix('/admin')->group(function () {

    Route::view('/', 'admin.dashboard')->name('admin.dashboard');

    Route::controller(ProfileController::class)
        ->name('profile.')
        ->prefix('/profile')
        ->group(function () {
            Route::get('/', 'edit')->name('edit');
            Route::patch('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');

            Route::get('/all', 'all')->name('all');
        });

    Route::controller(PostsController::class)
        ->name('post.')
        ->prefix('/post')
        ->group(function () {
            Route::get('/all', 'showPosts')->name('all');
            Route::get('/new', 'showNewPost')->name('create.form');
            Route::post('/new', 'createNewPost')->name('create');
            Route::get('/edit/{id}', 'showEditPost')->name('edit.form');
            Route::put('/edit/{id}', 'updateEditPost')->name('edit');
            Route::delete('/delete/{id}', 'deletePost')->name('soft.delete');

            Route::post('/rate', 'ajaxRate')->name('rate');
            Route::post('/publish', 'ajaxPublish')->name('publish');
        });

    Route::controller(CategoriesController::class)
        ->name('category.')
        ->prefix('/category')
        ->group(function () {
            Route::get('/all', 'showCategories')->name('all');
            Route::get('/new', 'showNewCategoryForm')->name('create.form');
            Route::post('/new', 'createNewCategory')->name('create');
        });
});


require __DIR__.'/auth.php';

