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

Route::get('/welcome', [PagesController::class, 'showWelcome']);
Route::get('/', [PagesController::class, 'showHome']);
Route::get('/test', [PagesController::class, 'showTest']);
Route::get('/post/{id}', [PostsController::class, 'getPostById']);
Route::get('/posts/{user_id}', [PostsController::class, 'getPostsByUserId']);
Route::get('/search', [PostsController::class, 'searchPostsByTerm']);

// ? Route::middleware(['auth', 'verified'])->group(function () {
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [PostsController::class, 'showDashboard'])->name('dashboard');
    Route::get('/dashboard/post/new', [PostsController::class, 'showNewPost'])->name('dashboard.show.new.post');
    Route::post('/dashboard/post/new', [PostsController::class, 'createNewPost'])->name('dashboard.create.new.post');
    Route::get('/dashboard/post/edit/{id}', [PostsController::class, 'showEditPost'])->name('dashboard.show.edit.post');
    Route::put('/dashboard/post/edit/{id}', [PostsController::class, 'updateEditPost'])->name('dashboard.update.edit.post');
    Route::delete('/dashboard/post/delete/{id}', [PostsController::class, 'deletePost'])->name('dashboard.delete.post');
    Route::patch('/dashboard/post/restore/{id}', [PostsController::class, 'restorePost'])->name('dashboard.restore.post');

    Route::get('/dashboard/category/new', [CategoriesController::class, 'showNewCategoryForm'])->name('newCategoryForm');
    Route::post('/dashboard/category/new', [CategoriesController::class, 'createNewCategory'])->name('createCategory');
});

require __DIR__.'/auth.php';
