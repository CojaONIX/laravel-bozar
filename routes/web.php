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
Route::get('/post/{id}', [PostsController::class, 'getPostById']);

Route::get('/dashboard', [PostsController::class, 'showDashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/post/new', [PostsController::class, 'showNewPost'])->middleware(['auth', 'verified'])->name('dashboard.show.new.post');
Route::post('/dashboard/post/new', [PostsController::class, 'createNewPost'])->middleware(['auth', 'verified'])->name('dashboard.create.new.post');
Route::get('/dashboard/post/edit/{id}', [PostsController::class, 'showEditPost'])->middleware(['auth', 'verified'])->name('dashboard.show.edit.post');
Route::put('/dashboard/post/edit/{id}', [PostsController::class, 'updateEditPost'])->middleware(['auth', 'verified'])->name('dashboard.update.edit.post');
Route::delete('/dashboard/post/delete/{id}', [PostsController::class, 'deletePost'])->middleware(['auth', 'verified'])->name('dashboard.delete.post');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
