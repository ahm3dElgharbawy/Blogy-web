<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $blogTitle = Setting::firstWhere('key', 'blog_title');
        $tagline = Setting::firstWhere('key', 'tagline');
        $postsPerPage = Setting::firstWhere('key', 'posts_per_page');
        $user = User::with('profile')->find(Auth::id());
        return view('dashboard.settings', compact('blogTitle', 'tagline', 'postsPerPage', 'user'));
    }

    public function updateBlog(Request $request)
    {

        foreach ($request->except('_token','_method') as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Settings saved!');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->profile()->updateOrCreate([], [
            'bio' => $request->bio,
        ]);

        return back()->with('success', 'Profile updated!');
    }
}
