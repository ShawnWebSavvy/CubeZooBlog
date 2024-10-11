<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ActivityController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Allow guests to view posts
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class)->except(['index'])->middleware('role:admin,author');
    Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::post('posts/{post}/comments', [PostController::class, 'storeComment'])->name('posts.comments.store');
});

Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Route to store comments for a specific post
//Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::get('/admin/activity-log', [ActivityController::class, 'index'])->name('activity-log.index')->middleware('role:admin');