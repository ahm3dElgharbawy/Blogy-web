<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\user\HomeController;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\user\UserPostController;
use Illuminate\Support\Facades\Route;

// ========================================
//              User Routes
// ========================================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login')->name('login.submit');
        Route::get('/register', 'showRegister')->name('register');
        Route::post('/register', 'register')->name('register.submit');
    });
    Route::get('/logout', 'logout')
        ->name('logout');
});

Route::prefix('user')->as('user.')->middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::prefix('blog/posts')->as('blog.')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('/create', [UserPostController::class, 'create'])->name('posts.create');
    Route::post('/', [UserPostController::class, 'store'])->name('posts.store');
    Route::get('/{id}/edit', [UserPostController::class, 'edit'])->name('posts.edit');
    Route::put('/{id}', [UserPostController::class, 'update'])->name('posts.update');
});
Route::get('blog/posts/{post}', [UserPostController::class, 'show'])->name('posts.show');
