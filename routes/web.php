<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\PostController;

// Show all posts
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Show create form
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

// Store new post
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

// Show a single post
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

// Show edit form
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');

// Update a post
Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');

// Delete a post
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
