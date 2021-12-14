<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserPostController::class, 'index'])->name('home');

// Admin Section

Route::group(['prefix' => 'admin', 'middleware' => ['can:admin']], function () {
    Route::resource('posts', AdminPostController::class)->except('show');
});


Route::group(['prefix' => 'user'], function(){
    Route::get('posts', [UserPostController::class, 'showAllMyPosts'])->name('user-posts');
    Route::get('posts/create', [UserPostController::class, 'create'])->name('user-post-create');
    Route::post('posts/store', [UserPostController::class, 'store'])->name('user-post-store');
    Route::get('posts/edit/{post}', [UserPostController::class, 'edit'])->name('user-post-edit');
    Route::patch('posts/update/{post}', [UserPostController::class, 'update'])->name('user-post-update');
    Route::delete('posts/destroy/{post}', [UserPostController::class, 'destroy'])->name('user-post-destroy');
});



Route::get('posts/{post:slug}', [UserPostController::class, 'show']);

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'create'])->middleware('guest');
Route::post('login', [SessionsController::class, 'store'])->middleware('guest');

Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');