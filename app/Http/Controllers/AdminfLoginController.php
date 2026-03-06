<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for admin-specific login.
 * Uses 'admin' guard to isolate admin session from user session.
 */
class AdminfLoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function adminfShowLoginForm()
    {
        /** @var User|null $admin */
        $admin = Auth::guard('admin')->user();
        if ($admin && $admin->isAdmin) {
            return redirect()->route('sitemanagement.blogs.index');
        }

        return view('admin_auth.login');
    }

    /**
     * Handle admin login attempt.
     */
    public function adminfLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->filled('remember');

        /** @var User|null $user */
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'User not found.',
            ])->withInput($request->only('email'));
        }

        if (!$user->isAdmin) {
            return back()->withErrors([
                'email' => 'This account does not have admin access.',
            ])->withInput($request->only('email'));
        }

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/sitemanagement/blogs');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Handle admin logout.
     */
    public function adminfLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sitemanagement.login');
    }
}
