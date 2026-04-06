<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\View;

class OverviewController extends Controller
{
    public function index()
    {
        $totalPosts = Post::count();

        $postsThisMonth = Post::where('created_at', '>=', now()->startOfMonth())->count();

        $commentsCount = 0;

        $subscribers = User::count(); // if users are subscribers
        $latestPosts = Post::with('category')
            ->withCount('views')
            ->latest()
            ->take(5)
            ->get();
        $viewsCount = View::where('created_at', '>=', now()->startOfWeek())->count();

        return view('dashboard.overview', compact('totalPosts', 'postsThisMonth', 'commentsCount', 'subscribers', 'latestPosts', 'viewsCount'));
    }
}
