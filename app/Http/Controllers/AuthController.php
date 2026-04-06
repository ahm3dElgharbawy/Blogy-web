<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(Request $request): View
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember)) {
            // $request->session()->regenerate();
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    public function showRegister(Request $request): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create(
            array_merge($request->only('name', 'email', 'password'), [
                'role' => 'user',
            ])
        );
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Account created successfully');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        // $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
