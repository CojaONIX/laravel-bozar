<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;

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
Route::get('/test/{model}/{id}', [PagesController::class, 'showTest']);
Route::get('/post/{id}', [PostsController::class, 'getPostById']);

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
});

require __DIR__.'/auth.php';
