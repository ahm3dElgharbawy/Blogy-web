<?php

use App\Http\Controllers\admin\AdminPostController;
use App\Http\Controllers\admin\AnalyticController;
use App\Http\Controllers\admin\CommentController;
use App\Http\Controllers\admin\OverviewController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\SubscriberController;
use Illuminate\Support\Facades\Route;

// ========================================
//              Admin Routes
// ========================================
// default prefix is 'admin/' and prefix name is 'admin.'

Route::middleware('admin')->group(function () {
    Route::get('dashboard', [OverviewController::class, "index" ])->name('dashboard');
    Route::get('analytics', [AnalyticController::class, "index" ])->name('analytics.index');
    Route::get('comments', [CommentController::class, "index" ])->name('comments.index');
    Route::get('settings', [SettingController::class, "index" ])->name('settings.index');
    Route::put('settings/blog/update', [SettingController::class, "updateBlog" ])->name('settings.blog.update');
    Route::put('settings/profile/update', [SettingController::class, "updateProfile" ])->name('settings.profile.update');
    Route::get('subscribers', [SubscriberController::class, "index" ])->name('subscribers.index');

    // Posts
    Route::resource("posts", AdminPostController::class);
});
