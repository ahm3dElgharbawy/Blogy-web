<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use HandlesImageUpload;

    public function index()
    {
        return view('user.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'avatar' => 'nullable|image|max:2048',
            'bio' => 'nullable',
            'password' => 'nullable|confirmed|min:6',
        ]);

        // Update user
        $user->update(array_merge(
            $request->only('name', 'email'),
            $request->filled('password') ? ['password' => Hash::make($request->password)] : []
        ));
        // Handle avatar
        if ($request->hasFile('avatar')) {
            $path = $this->uploadImage($request->file('avatar'), 'avatars');
            $user->profile()->updateOrCreate([], ['avatar' => $path]);
        }

        // Update profile
        $user->profile()->updateOrCreate([], [
            'bio' => $request->bio,
        ]);
        return back()->with('success', 'Profile updated');
    }
}
